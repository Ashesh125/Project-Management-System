<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\RegisteredUserController;

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

require __DIR__ . '/auth.php';

// Route::get('/', function () {
//     return view('auth.login');
// });


<<<<<<< HEAD
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/chartDatas/{id}',[DashboardController::class,'chartData'])->name('chartData');
//     Route::get('/activityDatas/{id}',[ActivityController::class,'activityData'])->name('activityData');
//     Route::get('/userDatas/{id}',[UserController::class,'userData'])->name('userData');
//     Route::get('/calanderDatas/{id}',[ActivityController::class,'activityDataOfUser'])->name('activityDataOfUser');
// });
=======
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/chartDatas/{id}',[DashboardController::class,'chartData'])->name('chartData');
    Route::get('/activityDatas/{id}',[ActivityController::class,'activityData'])->name('activityData');
    Route::get('/userDatas/{id}',[UserController::class,'userData'])->name('userData');
    Route::get('/calanderDatas/{id}',[ActivityController::class,'activityDataOfUser'])->name('activityDataOfUser');
});
>>>>>>> d3651fe (Dashboard Changes for roles)
