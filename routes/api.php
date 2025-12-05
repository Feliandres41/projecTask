<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\ProjectController;
// use App\Http\Controllers\TaskController;


// |----------------------------------------------------------------------
// | API Routes
// |----------------------------------------------------------------------
// | Aquí registras las rutas del API. Todas usan el middleware "api".


// Ruta para obtener información del usuario autenticado
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// RUTAS PROTEGIDAS POR SANCTUM (requieren token)
// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('projects', ProjectController::class);
//     Route::apiResource('tasks', TaskController::class);

//     Ruta adicional para marcar como completada
//     Route::put('tasks/{task}/complete', [TaskController::class, 'complete']);
// });

// RUTAS ABIERTAS (sin token, para pruebas)
// Route::apiResource('projects', ProjectController::class);
// Route::apiResource('tasks', TaskController::class);








use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Ruta de prueba para verificar que la API funciona
Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'API funcionando correctamente ✅',
        'timestamp' => now()->format('Y-m-d H:i:s'),
    ]);
});

// Rutas de Proyectos
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);           // GET /api/projects
    Route::post('/', [ProjectController::class, 'store']);          // POST /api/projects
    Route::get('/{id}', [ProjectController::class, 'show']);        // GET /api/projects/{id}
    Route::put('/{id}', [ProjectController::class, 'update']);      // PUT /api/projects/{id}
    Route::delete('/{id}', [ProjectController::class, 'destroy']);  // DELETE /api/projects/{id}
    Route::get('/{id}/tasks', [ProjectController::class, 'tasks']); // GET /api/projects/{id}/tasks
});

// Rutas de Tareas
Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);                  // GET /api/tasks
    Route::post('/', [TaskController::class, 'store']);                 // POST /api/tasks
    Route::get('/{id}', [TaskController::class, 'show']);               // GET /api/tasks/{id}
    Route::put('/{id}', [TaskController::class, 'update']);             // PUT /api/tasks/{id}
    Route::delete('/{id}', [TaskController::class, 'destroy']);         // DELETE /api/tasks/{id}
    Route::put('/{id}/complete', [TaskController::class, 'complete']);  // PUT /api/tasks/{id}/complete
    Route::put('/{id}/uncomplete', [TaskController::class, 'uncomplete']); // PUT /api/tasks/{id}/uncomplete
});

// Alternativa usando apiResource (más Laravel style - puedes usar este en lugar del anterior)
/*
Route::apiResource('projects', ProjectController::class);
Route::get('projects/{id}/tasks', [ProjectController::class, 'tasks']);

Route::apiResource('tasks', TaskController::class);
Route::put('tasks/{id}/complete', [TaskController::class, 'complete']);
Route::put('tasks/{id}/uncomplete', [TaskController::class, 'uncomplete']);
*/