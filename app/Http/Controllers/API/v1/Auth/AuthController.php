<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Student;
use App\Models\Study_Program;
use App\Models\StudyProgram;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Authentications Class
 *
 * @author Rena wijaya <crashyvjaya@gmail.com>
 * @since 1.0.0
 * @version 1.0.1
 * @copyright 2022 Rena wijaya
 */
class AuthController extends Controller
{
    /**
     * Undocumented function
     */
    public function __construct()
    {
        # code
    }

    /**
     * Login Validation function.
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'login_type'    =>  [
                'required',
                Rule::in(['STUDENT', 'TEACHER'])
            ],
            'device_name'   =>  [
                'required'
            ],
            'password'  =>  [
                'required'
            ]
        ]);

        if ($request->login_type === 'TEACHER') {
            $this->validate($request, [
                'email' =>  'required|email'
            ]);

            return $this->loginForTeacher($request);
        } else {
            $this->validate($request, [
                'student_number' =>  'required|numeric'
            ]);

            return $this->loginForStudent($request->student_number, $request->password, $request->device_name);
        }
    }

    /**
     * Register Validation function.
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'login_type'    =>  [
                'required',
                Rule::in(['STUDENT', 'TEACHER'])
            ],
            'student_number'    =>  [
                'required',
                'numeric'
            ],
            'password'  =>  [
                'required'
            ],
            'confirm_password'  =>  [
                'required',
                'same:password'
            ]
        ]);

        if ($request->login_type === 'TEACHER') {
            $this->validate($request, [
                'email' =>  'required|email'
            ]);

            // return $this->loginForTeacher($request->email);
        } else {
            $this->validate($request, [
                'student_number' =>  'required|numeric'
            ]);

            return $this->registerForStudent($request->student_number, $request->password);
        }
    }

    /**
     * Login For Student function.
     *
     * @param string $student_number
     * @param string $password
     * @param string $device_name
     * @return void
     */
    public function loginForStudent($student_number, $password, $device_name)
    {
        $student = Student::where('student_number', '=', $student_number)->first();

        if ($student) {

            $user = User::where('student_id', $student->id)->first();

            // check if the user isn't registered
            if (!$user) {
                return response()->json([
                    'status'    =>  [
                        'code'  =>  404,
                        'description'   =>  'Not found',
                        'message'   =>  'User belum terdaftar.'
                    ]
                ], 404);
            }

            if (Hash::check($password, $user->password)) {

                $token = $user->createToken($device_name)->plainTextToken;

                return response()->json([
                    'status'    =>  [
                        'code'  =>  200,
                        'description'   =>  'OK'
                    ],
                    'results'   =>  [
                        'token' =>  $token,
                    ]
                ]);
            } else {
                return response()->json([
                    'status'    =>  [
                        'code'  =>  401,
                        'description'   =>  'Unauthorized',
                        'message'   =>  'Password salah.'
                    ]
                ], 401);
            }
        } else {
            return response()->json([
                'status'    =>  [
                    'code'  =>  401,
                    'description'   =>  'Unauthorized',
                    'message'   =>  'NIM tidak ditemukan.'
                ]
            ], 401);
        }
    }

    /**
     * Register For Student function.
     *
     * @param string $student_number
     * @param string $password
     * @return void
     */
    public function registerForstudent($student_number, $password)
    {
        $configurations = DB::table('configurations')->where('id', '=', 1)->first();

        $student = DB::table('students')->where('student_number', '=', $student_number)->first();

        $student_id = $student->id;

        $user = DB::table('users')->where('student_id', '=', $student_id)->first();

        if ($user) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  422,
                    'description'   =>  'Unprocessable Content',
                ],
                'results'   =>  [
                    'errors'    =>  [
                        'student_number'    => ['Data sudah terdaftar.']
                    ]
                ]
            ], 422);
        }

        DB::table('users')->insert([
            'student_id'    =>  $student_id,
            'password'  =>  Hash::make($password),
            'is_admin'  =>  false,
            'is_activated'   =>  $configurations->force_activate_users,
            'is_voted'  =>  false,
            'created_at'    =>  now()
        ]);

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK',
                'message'   =>  'Pendaftaran berhasil.'
            ]
        ]);
    }

    /**
     * Login for teacher function
     *
     * @param object $request
     * @return void
     */
    public function loginForTeacher($request)
    {
        $teacher = Teacher::where('email', '=', $request->email)->first();

        if ($teacher) {

            $user = User::where('teacher_id', $teacher->id)->first();

            // check if the user isn't registered
            if (!$user) {
                return response()->json([
                    'status'    =>  [
                        'code'  =>  404,
                        'description'   =>  'Not found',
                        'message'   =>  'User belum terdaftar.'
                    ]
                ], 404);
            }

            if (Hash::check($request->password, $user->password)) {

                $token = $user->createToken($request->device_name)->plainTextToken;

                return response()->json([
                    'status'    =>  [
                        'code'  =>  200,
                        'description'   =>  'OK'
                    ],
                    'results'   =>  [
                        'token' =>  $token,
                    ]
                ]);
            } else {
                return response()->json([
                    'status'    =>  [
                        'code'  =>  401,
                        'description'   =>  'Unauthorized',
                        'message'   =>  'Password salah.'
                    ]
                ], 401);
            }
        } else {
            return response()->json([
                'status'    =>  [
                    'code'  =>  401,
                    'description'   =>  'Unauthorized',
                    'message'   =>  'Email tidak ditemukan.'
                ]
            ], 401);
        }
    }

    /**
     * Get userdata logged.
     *
     * @param Request $request
     * @return void
     */
    public function getUserdata(Request $request)
    {
        $userdata = $request->user();

        if ($userdata['student_id'] !== null) {

            $student = Student::where('id', '=', $userdata['student_id'])->first();
            $study_program = StudyProgram::where('id', '=', $student->study_program_id)->first(['id', 'name', 'description']);

            return response()->json([
                'status'    =>  [
                    'code'  =>  200,
                    'description'   =>  'OK'
                ],
                'results'   =>  [
                    'userdata'  =>  $userdata,
                    'personal_data' =>  $student,
                    'study_program' =>  $study_program
                ]
            ]);
        } elseif ($userdata['teacher_id'] !== null) {

            $teacher = Teacher::where('id', '=', $userdata['teacher_id'])->first();

            return response()->json([
                'status'    =>  [
                    'code'  =>  200,
                    'description'   =>  'OK'
                ],
                'results'   =>  [
                    'userdata'  =>  $userdata,
                    'personal_data' =>  $teacher,
                ]
            ]);
        } else {

            $userdata->currentAccessToken()->delete();

            return response()->json([
                'status'    =>  [
                    'code'  =>  500,
                    'description'   =>  'Internal Server Error',
                    'message'   =>  'Unknown ID.'
                ]
            ], 500);
        }

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  [
                'userdata'  =>  $userdata
            ]
        ]);
    }

    /**
     * Logout function.
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK',
                'message'   =>  'Logout Berhasil.'
            ],
        ]);
    }
}
