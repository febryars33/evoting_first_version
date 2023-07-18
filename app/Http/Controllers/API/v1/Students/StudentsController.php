<?php

namespace App\Http\Controllers\API\v1\Students;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Student;
use App\Models\StudyProgram;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestor = $request->user();

        if ($requestor->is_admin === 0) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  401,
                    'description'   => 'Unauthorized'
                ]
            ], 401);
        }

        $q = $request->get('search');

        $students = DB::table('students')->join('study_programs', 'students.study_program_id', '=', 'study_programs.id');

        if ($q) {
            $students->where('students.name', 'like', '%' . $q . '%')->orWhere('student_number', 'like', '%' . $q . '%');
        }

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  $students->paginate(15, [
                'students.id as id',
                'study_programs.id as study_program_id',
                'student_number',
                'students.name',
                'study_programs.name as study_program_name',
                'students.created_at',
                'students.updated_at',
            ])->onEachSide(0)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestor = $request->user();

        if ($requestor->is_admin === false) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  401,
                    'description'   =>  'Unauthorized'
                ]
            ], 401);
        }

        $this->validate($request, [
            'student_number'    =>  'required|numeric|unique:students',
            'name'  =>  'required|regex:/^[\pL\s\-]+$/u',
            'place_birth'   =>  'required',
            'date_birth'    =>  'required|date',
            'study_program_id'  =>  'required|numeric'
        ], [], [
            'student_number'    =>  'NIM',
            'name'  =>  'Nama Lengkap',
            'place_birth'   =>  'Tempat Lahir',
            'date_birth'    =>  'Tanggal Lahir',
            'study_program_id'  =>  'Program Studi'
        ]);

        DB::beginTransaction();
        try {
            $student = new Student;
            $student->study_program_id  =  $request->study_program_id;
            $student->student_number    =  $request->student_number;
            $student->name  =  strtoupper($request->name);
            $student->place_birth   =  strtoupper($request->place_birth);
            $student->date_birth    =  $request->date_birth;
            $student->created_at    =  now();
            $student->save();

            $user = new User;
            $user->student_id = $student->id;
            $user->teacher_id = null;
            $user->password   = Hash::make(str_replace('/', '', date('d/m/Y', strtotime($student->date_birth))));
            $user->is_admin   = false;
            $user->is_activated = (Configuration::find(1))->force_activate_users;
            $user->is_password_changed = false;
            $user->is_voted   = false;
            $user->save();

            DB::commit();
            return response()->json([
                'status'    =>  [
                    'code'  =>  201,
                    'description'   =>  'Created'
                ]
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'    =>  [
                    'code'  =>  500,
                    'description'   =>  JsonResponse::$statusTexts[500]
                ]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $requestor = $request->user();

        if ($requestor->is_admin === 0) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  401,
                    'description'   =>  'Unauthorized'
                ]
            ], 401);
            die;
        }

        DB::table('students')->where('id', '=', $id)->delete();

        return response(null, 204);
    }

    public function getByStudentNumber(Request $request, $student_number)
    {
        $requestor = $request->user();

        if ($requestor->is_admin === 0) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  401,
                    'description'   =>  'Unauthorized'
                ]
            ]);
            die;
        }

        $student = Student::where('student_number', '=', $student_number)->first();
        $study_program = StudyProgram::where('id', '=', $student->study_program_id)->first();
        $user = User::where('student_id', '=', $student->id)->first();

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  [
                'student'   =>  $student,
                'study_program' =>  $study_program,
                'user'  =>  $user
            ]
        ]);
    }
}
