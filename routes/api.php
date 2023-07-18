<?php

use App\Http\Controllers\API\RealtimeChartController;
use App\Http\Controllers\API\v1\Auth\AuthController;
use App\Http\Controllers\API\v1\Candidates\CandidatesController;
use App\Http\Controllers\API\v1\Candidates\VotingController;
use App\Http\Controllers\API\v1\Configs\VotingController as ConfigsVotingController;
use App\Http\Controllers\API\v1\Realtimes\ChartController;
use App\Http\Controllers\API\v1\Students\StudentsController;
use App\Http\Controllers\API\v1\StudyPrograms\StudyProgramsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| Grouping Routes
|--------------------------------------------------------------------------
*/
//  API Version 1
Route::group(['prefix' => '/v1'], function () {

    /*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

    /*
    |--------------------------------------------------------------------------
    | Authentication API URL Paths
    |--------------------------------------------------------------------------
    */

    // Authentication API URL Path
    Route::group(['prefix' => '/auth'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);

        /*
        |--------------------------------------------------------------------------
        | Authentication API URL Paths with Middleware
        |--------------------------------------------------------------------------
        */
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::group(['prefix' => '/session'], function () {
                Route::get('/userdata', [AuthController::class, 'getUserdata']);
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Realtimes API URL Paths with Middleware
    |--------------------------------------------------------------------------
    */
    // Route::group(['middleware' => 'auth:sanctum'], function () {
    //     Route::group(['prefix' => '/realtimes'], function () {
    //         Route::get('/chart', [ChartController::class, 'livechart']);
    //     });
    // });

    /*
    |--------------------------------------------------------------------------
    | Candidates API URL Paths with Middleware
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::group(['prefix' => '/candidates'], function () {
            Route::get('/', [CandidatesController::class, 'index']);
            Route::post('/', [CandidatesController::class, 'store']);
            Route::get('/{id}', [CandidatesController::class, 'show']);
            Route::post('/vote', [VotingController::class, 'voteCandidate']);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Configurations API URL Paths with Middleware
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::group(['prefix' => '/configurations'], function () {
            Route::get('/', [ConfigsVotingController::class, 'index']);

            Route::group(['prefix' => '/voting'], function () {
                Route::get('/counts', [ConfigsVotingController::class, 'votingCounts']);
            });

            Route::post('/expired-at', [ConfigsVotingController::class, 'expireDate']);

            // Teachers
            Route::group(['prefix' => '/teachers'], function () {
                Route::post('/score', [ConfigsVotingController::class, 'teacherScoreEdit']);
            });

            // Students
            Route::group(['prefix' => '/students'], function () {
                Route::post('/score', [ConfigsVotingController::class, 'studentScoreEdit']);
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Students API URL Paths with Middleware
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => '/students'], function () {
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('/', [StudentsController::class, 'index']);
            Route::post('/', [StudentsController::class, 'store']);
            Route::get('/student-number/{student_number}', [StudentsController::class, 'getByStudentNumber']);
            Route::delete('/{id}', [StudentsController::class, 'destroy']);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Study Programs API URL Paths with Middleware
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => '/study-programs'], function () {
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('/', [StudyProgramsController::class, 'index']);
        });
    });

    Route::get('/quick-count', [RealtimeChartController::class, 'getChart']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum');
Route::group(['middleware'  =>  'auth:sanctum'], function () {
    Route::get('/sanctum', function () {
        return true;
    });
});
