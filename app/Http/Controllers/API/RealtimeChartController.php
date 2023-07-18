<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Configuration;
use App\Models\User;
use Carbon\Carbon;

class RealtimeChartController extends Controller
{
    protected $label = [];

    protected $score = [];

    protected $color = [];

    public function getChart(bool $socket = false)
    {
        $candidate = Candidate::with(['student'])->get();
        $configurations = Configuration::find(1);
        foreach ($candidate as $key => $value) {
            $this->score[$key] = (int) $value['score'];
            $this->color[$key] = $value['color'];
            if (Carbon::now() >= Carbon::createFromFormat('Y-m-d H:i:s', $configurations->voting_expired)) {
                $this->label[$key] = $value['student']['name'];
            } else {
                $this->label[$key] = '*****';
            }
        }


        $array = [
            'status'    =>  [
                'code'  =>  200,
                'description'   =>  'OK'
            ],
            'results'   =>  [
                'label' =>  $this->label,
                'score' =>  $this->score,
                'color' =>  $this->color,
                'voted' =>  [
                    User::where('is_voted', '=', true)->count(),
                    User::where('is_voted', '=', false)->count()
                ]
            ]
        ];

        if ($socket) {
            return $array;
        }

        return response()->json($array);
    }
}
