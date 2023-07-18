<?php

namespace App\Http\Controllers\API\v1\Candidates;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Candidates Class
 *
 *
 *
 * @author Rena wijaya <crashyvjaya@gmail.com>
 * @since 1.0.0
 * @version 1.0.1
 * @copyright 2022 Rena wijaya
 */

class CandidatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidates = Candidate::with('student', 'student.study_program')->get();

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  $candidates
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
        $this->validate($request, [
            'id'    =>  'required|numeric',
            'description'   =>  'required',
            'color' =>  'required',
        ]);

        $requestor = $request->user();

        if ($requestor->is_admin === true) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  401,
                    'description'   =>  'Unauthorized'
                ]
            ], 401);
        }

        $candidate = new Candidate;
        $candidate->student_id    =  $request->id;
        $candidate->description   =  $request->description;
        $candidate->score =  0;
        $candidate->color = $request->color;
        $candidate->is_disqualified   =  false;
        $candidate->created_at    =  now();
        $candidate->save();

        return response()->json([
            'status'    =>  [
                'code'  =>  201,
                'description'   =>  'Created',
                'message'   =>  'Kandidat berhasil dibuat.'
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidates = Candidate::with(['student', 'student.study_program'])->where('id', '=', $id)->first();

        if (!$candidates) {
            return response()->json([
                'status'    =>  [
                    'code'  =>  404,
                    'description'   =>  JsonResponse::$statusTexts[404],
                    'message'   =>  'Kandidat tidak ditemukan.'
                ]
            ], 404);
        }

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  [
                'candidates'    =>  $candidates,
            ]
        ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
