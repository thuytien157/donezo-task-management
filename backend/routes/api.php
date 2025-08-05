<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskHistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->get('/logout', [UserController::class, 'logout']);
Route::get('/{provider}/redirect', [UserController::class, 'redirect']);
Route::get('/{provider}/callback', [UserController::class, 'callback']);
Route::post('/forgot-password', [UserController::class, 'sendResetLink']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::resource('project', ProjectController::class)->middleware('auth:sanctum');;
Route::put('/task/update-status', [TaskController::class, 'updateStatus']);
Route::put('/task/update-description', [TaskController::class, 'updateDescription']);
Route::post('/task/upload-image', [TaskController::class, 'uploadImage']);
Route::resource('task', TaskController::class);
Route::resource('task-history', TaskHistoryController::class);
Route::get('/project-member/{project_id}', [ProjectMemberController::class, 'getMemberByProject']);
Route::post('/invite-member', [ProjectMemberController::class, 'inviteMember'])->middleware('auth:sanctum');
Route::post('/invite-member-accepted', [ProjectMemberController::class, 'acceptInvitation'])->middleware('auth:sanctum');
