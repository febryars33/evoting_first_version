<?php

namespace App\Http\Controllers\API\v1\Candidates;

use App\Events\Chart;
use App\Events\MyEvent;
use App\Http\Controllers\API\RealtimeChartController;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Configuration;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Http\JsonResponse;

/**
 * Voting Class
 *
 * * @author Rena wijaya <crashyvjaya@gmail.com>
 * @since 1.0.0
 * @version 1.0.1
 * @copyright 2022 Rena wijaya
 */
class VotingController extends Controller
{
    /**
     * Constructor function
     */
    public function __construct()
    {
        # code
    }

    /**
     * Vote candidate by students or teachers.
     *
     * @param Request $request
     * @return void
     */
    public function voteCandidate(Request $request)
    {
        // validation first
        $this->validate($request, [
            'candidates_id'    =>  'required|numeric'
        ]);

        // get userdata
        $user = $request->user();

        // validation if user has voted
        if ($user['is_voted'] == true) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  403,
                    'description'   =>  'Forbidden',
                    'message'   =>  'Maaf ya... Sepertinya kamu sudah memilih sebelumnya.'
                ]
            ], 403);
            die;
        }

        $configurations = Configuration::find(1);
        setlocale(LC_ALL, 'IND');

        if (Carbon::now() < Carbon::createFromFormat('Y-m-d H:i:s', $configurations->voting_start)) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  403,
                    'description'   =>  'Forbidden',
                    'message'   =>  'Sabar ya... Voting dimulai tanggal ' . Carbon::parse($configurations->voting_start)->isoFormat('dddd, DD MMMM YYYY') . ' Jam ' . Carbon::parse($configurations->voting_start)->format('H:i')
                ]
            ], 403);
            die;
        }

        if (Carbon::now() > Carbon::createFromFormat('Y-m-d H:i:s', $configurations->voting_expired)) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  403,
                    'description'   =>  'Forbidden',
                    'message'   =>  'Maaf yaa... Batas waktu voting telah berakhir.'
                ]
            ], 403);
            die;
        }

        $candidates = DB::table('candidates')->join('students', 'candidates.student_id', '=', 'students.id')->where('students.id', '=', $user->student_id)->first();

        if ($candidates) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  403,
                    'description'   =>  'Forbidden',
                    'message'   =>  'Lahh..?? kan kamu calon ketua nya'
                ]
            ], 403);
            die;
        }

        DB::beginTransaction();
        try {
            //updating is_voted user data
            $userdata = User::find($user['id']);

            // set is voted to true
            $userdata->is_voted = true;

            // save it
            $userdata->save();

            // actions to increase the score here
            DB::table('candidates')->where('id', '=', $request->candidates_id)->update([
                'score' =>  DB::raw('score+1'),
                'updated_at'    =>  now()
            ]);
            DB::commit();

            event(new MyEvent(
                (new RealtimeChartController)->getChart(true)
            ));

            // returns response with json format
            return response()->json([
                'status'    =>  [
                    'code'  =>  200,
                    'description'   =>  'OK'
                ],
            ]);
        } catch (Exception $e) {
            // returns response with json format
            DB::rollBack();
            return response()->json([
                'status'    =>  [
                    'code'  =>  500,
                    'description'   =>  JsonResponse::$statusTexts[500]
                ],
            ], 500);
        }
    }
}
