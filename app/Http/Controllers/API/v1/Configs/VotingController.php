<?php

namespace App\Http\Controllers\API\v1\Configs;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Voting Config Class
 *
 *  * @author Rena wijaya <crashyvjaya@gmail.com>
 * @since 1.0.0
 * @version 1.0.1
 * @copyright 2022 Rena wijaya
 */
class VotingController extends Controller
{
    /**
     * Constructor function.
     */
    public function __construct()
    {
        # code ...
    }

    /**
     * Get all the Configurations.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->is_admin === false) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  403,
                    'description'   =>  'Forbidden'
                ]
            ], 403);
        }

        $configurations = Configuration::query()->first();

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  $configurations
        ]);
    }

    /**
     * Teacher Score Edit function.
     *
     * @param Request $request
     * @return void
     */
    public function teacherScoreEdit(Request $request)
    {
        $this->validate($request, [
            'score' =>  'required|numeric|min:1'
        ]);

        $requestor = $request->user();

        if ($request->is_admin === false) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  403,
                    'description'   =>  'Forbidden'
                ]
            ], 403);
        }

        $configurations = DB::table('configurations')->first();

        if ($configurations->teacher_score === $request->score) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  304,
                    'description'   =>  'Not Modified'
                ]
            ], 304);
        }

        DB::table('configurations')->update([
            'teacher_score' =>  $request->score
        ]);

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  [
                'message'   =>  'Score Dosen berhasil diupdate.'
            ]
        ]);
    }

    /**
     * Student Score Edit function.
     *
     * @param Request $request
     * @return void
     */
    public function studentScoreEdit(Request $request)
    {
        $this->validate($request, [
            'score' =>  'required|numeric|min:1'
        ]);

        if ($request->is_admin === false) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  403,
                    'description'   =>  'Forbidden'
                ]
            ], 403);
        }

        $configurations = DB::table('configurations')->first();

        if ($configurations->student_score === $request->score) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  304,
                    'description'   =>  'Not Modified'
                ]
            ], 304);
        }

        DB::table('configurations')->update([
            'student_score' =>  $request->score
        ]);

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  [
                'message'   =>  'Score Mahasiswa berhasil diupdate.'
            ]
        ]);
    }

    /**
     * Voting Expire time function.
     *
     * @param Request $request
     * @return void
     */
    public function expireDate(Request $request)
    {
        $this->validate($request, [
            'date' =>  'required|date'
        ]);

        if ($request->is_admin === false) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  403,
                    'description'   =>  'Forbidden'
                ]
            ], 403);
        }

        $configurations = DB::table('configurations')->first();

        if ($configurations->voting_expired === $request->date) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  304,
                    'description'   =>  'Not Modified'
                ]
            ], 304);
        }

        DB::table('configurations')->update([
            'voting_expired' =>  $request->date,
            'updated_at'    =>  now()
        ]);

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  [
                'message'   =>  'Batas waktu voting berhasil diupdate.'
            ]
        ]);
    }

    public function votingCounts(Request $request)
    {
        if ($request->is_admin === false) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  403,
                    'description'   =>  'Forbidden'
                ]
            ], 403);
        }

        $users_voted = DB::table('users')->where('is_voted', '=', true)->count();
        $users_not_voted = DB::table('users')->where('is_voted', '=', false)->count();

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  [
                'voted' =>  $users_voted,
                'not_voted' =>  $users_not_voted,
            ]
        ]);
    }

    public function forceActiveUsee()
    {
        $configuration = new Configuration;
        $configuration->update(['force_activate_users' => true]);
        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK',
                'message'   =>  'Berhasil diupdate'
            ]
        ]);
    }
}
