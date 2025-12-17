<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{id}/complete', [TaskController::class, 'complete']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::patch(
    '/projects/{project}/tasks/{task}/toggle',
    [TaskController::class, 'toggle']
    )->middleware('auth:sanctum');
    
});
