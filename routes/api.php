<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
| Aquí registras las rutas del API. Todas usan el middleware "api".
*/

// Ruta para obtener información del usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// RUTAS PROTEGIDAS POR SANCTUM (requieren token)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('tasks', TaskController::class);

    // Ruta adicional para marcar como completada
    Route::put('tasks/{task}/complete', [TaskController::class, 'complete']);
});

// RUTAS ABIERTAS (sin token, para pruebas)
Route::apiResource('projects', ProjectController::class);
Route::apiResource('tasks', TaskController::class);
