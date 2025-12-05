<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/logout',   [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('projects', ProjectController::class);

    Route::apiResource('tasks', TaskController::class)->only([
        'store', 'update', 'destroy'
    ]);

    Route::put('/tasks/{task}/complete', [TaskController::class, 'complete']);
});
