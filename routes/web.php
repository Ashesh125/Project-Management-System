<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/projects', [ProjectController::class, 'index'])->middleware(['auth', 'verified'])->name('projects');
Route::post('/projects/check', [ProjectController::class, 'check'])->middleware(['auth', 'verified'])->name('checkProject');

Route::get('/projectdetail/{id?}', [ProjectController::class, 'tasks'])->middleware(['auth', 'verified'])->name('projectdetail');
Route::post('/tasks/check', [TasksController::class, 'check'])->middleware(['auth', 'verified'])->name('checkTask');

Route::get('/mytasks/table', [UserController::class, 'mytasks'])->middleware(['auth', 'verified'])->name('mytasksT');
Route::post('/tasks/updateType', [TasksController::class, 'updateType'])->middleware(['auth', 'verified'])->name('taskTypeUpdate');
Route::get('/mytasks/kanban', [UserController::class, 'mytaskskanban'])->middleware(['auth', 'verified'])->name('mytasksK');

Route::get('/myprojects/{id?}', [TasksController::class, 'test'])->middleware(['auth', 'verified'])->name('myprojects');


Route::get('/test', function(){
    return view('test');
})->name('test');
