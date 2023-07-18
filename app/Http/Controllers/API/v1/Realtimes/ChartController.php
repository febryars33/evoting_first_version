<?php

namespace App\Http\Controllers\API\v1\Realtimes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    /**
     * Undocumented function
     */
    public function __construct()
    {
        # code ...
    }

    public function livechart()
    {
        $candidates = DB::table('candidates')->join('students', 'students.id', '=', 'candidates.student_id')->get([
            'id'    =>  'candidates.id',
            'name'  =>  'students.name',
            'score' =>  'candidates.score',
            'color' =>  'candidates.color'
        ]);

        return response()->json([
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  $candidates
        ]);
    }
}
