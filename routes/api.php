<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\PriorityController;




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

Route::middleware('auth:sanctum')->get('/user', [UserController::class , 'users']);

Route::middleware('auth:sanctum')->get('/auth/logout', [AuthController::class , 'logout']);

Route::group(['prefix'=>'/auth'], function(){
    Route::POST('/register'  , [AuthController::class , 'register']);
    Route::POST('/login'  , [AuthController::class , 'login']);
});

//task
Route::group(['middleware'=>'auth:sanctum','prefix'=>'tasks'] ,function(){
    Route::GET('/{id}', [TaskController::class , 'getTaskId']);
    Route::POST('/', [TaskController::class , 'createTask']);
    Route::PUT('/{id}', [TaskController::class , 'updateTask']);
    Route::DELETE('/{id}', [TaskController::class , 'deleteTask']);

    //modify task, update task attribute
    Route::PUT('/{taskid}/{attributeid}' , [TaskController::class , 'updateTaskAttribute']);
    Route::DELETE('/{taskid}/{attributeid}' , [TaskController::class , 'deleteTaskAttribute']);

    //assign task to member
    Route::POST('/{taskid}/assign' ,[TaskController::class , 'assign']);

    //comment on task 
    Route::POST('/{taskid}/comments' , [CommentController::class , 'createComment']);
    Route::GET('/{taskid}/comments' , [CommentController::class , 'getComment']);
    
    //task status
    Route::PUT('/{taskid}/status/update' , [StatusController::class , 'updateStatus']);

    //task priority
    Route::PUT('/{taskid}/priority/update' , [PriorityController::class , 'updatePriority']);

});

//user
Route::group(['middleware' => 'auth:sanctum','prefix'=>'user'], function(){
    Route::GET('/{userId}/tasks' , [UserController::class , 'tasks']);
});