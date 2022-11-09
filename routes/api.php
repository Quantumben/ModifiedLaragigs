<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\api\JobController;
use App\Http\Controllers\api\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Public Route
Route::post('/signup', [UserController::class, 'register']);
Route::post('/signin', [UserController::class, 'login']);

//Route::get('all-job', [JobController::class, 'index']);
//Protected Route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('job', [JobController::class, 'index']);
    Route::get('job/{id}', [JobController::class, 'show']);
    Route::post('job', [JobController::class, 'store']);
    Route::put('job/{id}', [JobController::class, 'update']);
    Route::delete('job/{id}', [JobController::class, 'destroy']);

    Route::post('logoff', [UserController::class, 'logout']);
});
