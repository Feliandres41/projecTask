<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Aquí se registran todas las rutas de la API.
| Estas rutas son cargadas por el RouteServiceProvider dentro del grupo
| que contiene el middleware "api".
|--------------------------------------------------------------------------
*/

// -------------------------
// 🔐 AUTENTICACIÓN
// -------------------------

// Crear usuario
Route::post('/register', [AuthController::class, 'register']);

// Iniciar sesión
Route::post('/login', [AuthController::class, 'login']);

// Cerrar sesión (requiere token)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');


// -------------------------
// 🔒 RUTAS PROTEGIDAS (requieren estar logueado)
// -------------------------

Route::middleware('auth:sanctum')->group(function () {

    // ----------------------------------------
    // 📌 CRUD Proyectos
    // ----------------------------------------
    Route::apiResource('projects', ProjectController::class);


    // ----------------------------------------
    // 📌 CRUD Tareas (solo store, update, delete)
    // ----------------------------------------
    Route::apiResource('tasks', TaskController::class)->only([
        'store', 'update', 'destroy'
    ]);

    // Marcar tarea como completada
    Route::put('/tasks/{task}/complete', [TaskController::class, 'complete']);
});
