<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request)
    {
        $project = Project::where('id', $request->project_id)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        $task = Task::create($request->validated());

        return new TaskResource($task);
    }


    public function update(StoreTaskRequest $request, Task $task)
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $task->update($request->validated());

        return new TaskResource($task);
    }


    public function destroy(Task $task)
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Tarea eliminada']);
    }


    public function complete(Task $task)
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $task->update(['is_completed' => true]);

        return new TaskResource($task);
    }

    public function toggle($projectId, $taskId)
    {
        $task = Task::where('project_id', $projectId)
                    ->where('id', $taskId)
                    ->firstOrFail();

        $task->completed = !$task->completed;
        $task->save();

        return response()->json([
            'message' => 'Estado actualizado',
            'task' => $task
        ]);
    }
}
