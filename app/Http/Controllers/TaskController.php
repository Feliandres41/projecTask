<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    // POST /api/tasks
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required|integer',
            'title'      => 'required|string|max:255',
        ]);

        $project = Project::where('id', $data['project_id'])
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$project) {
            return response()->json([
                'message' => 'No tienes permiso para agregar tareas a este proyecto'
            ], 403);
        }

        $task = Task::create([
            'project_id'   => $project->id,
            'title'        => $data['title'],
            'is_completed' => false,
        ]);

        return response()->json($task, 201);
    }

    // PUT /api/tasks/{id}/complete
    public function complete(Request $request, $id)
    {
        $task = Task::where('id', $id)
            ->whereHas('project', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->first();

        if (!$task) {
            return response()->json([
                'message' => 'No autorizado'
            ], 403);
        }

        $task->update(['is_completed' => true]);

        return response()->json([
            'message' => 'Tarea completada',
            'task' => $task
        ]);
    }
    public function toggle($projectId, $taskId)
    {
        $task = Task::where('project_id', $projectId)
                    ->where('id', $taskId)
                    ->firstOrFail();

        $task->is_completed = ! $task->is_completed;
        $task->save();

        return response()->json([
            'message' => 'Estado actualizado',
            'task' => $task
        ]);
    }
}
