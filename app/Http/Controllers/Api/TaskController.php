<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    // Crear tarea
    public function store(StoreTaskRequest $request)
    {
        // Verificar que el proyecto sea del usuario
        $project = Project::where('id', $request->project_id)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        $task = Task::create($request->validated());

        return new TaskResource($task);
    }


    // Actualizar tarea
    public function update(StoreTaskRequest $request, Task $task)
    {
        // Verificar que la tarea sea del usuario
        if ($task->project->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $task->update($request->validated());

        return new TaskResource($task);
    }


    // Eliminar tarea
    public function destroy(Task $task)
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Tarea eliminada']);
    }


    // Marcar tarea como completada
    public function complete(Task $task)
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $task->update(['is_completed' => true]);

        return new TaskResource($task);
    }
}
