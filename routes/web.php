<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;

use App\Http\Controllers\Auth\RegisteredUserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('auth.login');
});


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/chartDatas/{id?}', [DashboardController::class, 'chartData'])->name('chart');

    Route::get('/project', [ProjectController::class, 'index'])->name('projects');
    Route::get('/projectCard', [ProjectController::class, 'cardView'])->name('projectCard');

    Route::get('/activity', [ActivityController::class, 'index'])->name('activity');
    Route::get('/activitydetail/{id?}', [ActivityController::class, 'show'])->name('activityDetail');
    Route::get('/projectdetail/{id?}', [ProjectController::class, 'show'])->name('projectDetail');

    Route::get('/mytasks/{type}/{id?}', [TasksController::class, 'usertasks'])->name('myTasks');
    Route::get('/calanderview/{id?}', [TasksController::class, 'index'])->name('calander');


    Route::post('/tasks/updateType', [TasksController::class, 'updateType'])->name('taskTypeUpdate');

    Route::get('/myactivity/{type?}', [UserController::class, 'myActivities'])->name('myActivities');
    Route::get('/myissues', [UserController::class, 'myIssues'])->name('myIssues');

    Route::get('/profile', [UserController::class, 'edit'])->name('profile');
    Route::get('/users', [UserController::class, 'index'])->name('users');

    Route::get('/issues/{id?}', [IssueController::class, 'ofActivity'])->name('issues');
    Route::post('/issues', [IssueController::class, 'check'])->name('checkIssue');

    Route::get('/comment/{id?}', [CommentController::class, 'ofIssue'])->name('comments');
    Route::post('/comment', [CommentController::class, 'check'])->name('checkComment');

    Route::get('/chartDatas/{id}',[DashboardController::class,'chartData'])->name('chartData');
    Route::get('/activityDatas/{id}',[ActivityController::class,'activityData'])->name('activityData');
    Route::get('/userDatas/{id}',[UserController::class,'userData'])->name('userData');
    Route::get('/calanderDatas/{id}',[ActivityController::class,'activityDataOfUser'])->name('activityDataOfUser');


    Route::post('/updateProfile', [UserController::class, 'updateProfile'])->name('updateProfile');


    /* for project manager (role = 1) or higher level of clerence  */
    Route::middleware(['role'])->group(function () {
        Route::post('/activities', [ActivityController::class, 'check'])->name('checkActivity');
        Route::post('/tasks', [TasksController::class, 'check'])->name('checkTask');
    });

    /* for super admin (role = 2) or higher level of clerence  */
    Route::middleware(['user'])->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::post('/projects', [ProjectController::class, 'check'])->name('checkProject');
        Route::post('/users', [UserController::class, 'check'])->name('checkUser');

        Route::get('/updateActivities', [ActivityController::class ,'globalStatusUpdater']);
    });
});
