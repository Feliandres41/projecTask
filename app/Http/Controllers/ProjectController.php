<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Project::with('tasks')
                ->where('user_id', $request->user()->id)
                ->get()
        );
    }

    // POST /api/projects
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $project = Project::create([
            'name' => $data['name'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json($project, 201);
    }

    // GET /api/projects/{id}
    public function show(Request $request, $id)
    {
        $project = Project::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with('tasks')
            ->firstOrFail();

        return response()->json($project);
    }

    // PUT /api/projects/{id}
    public function update(Request $request, $id)
    {
        $project = Project::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $project->update(
            $request->validate([
                'name' => 'required|string|max:255',
            ])
        );

        return response()->json($project);
    }

    // DELETE /api/projects/{id}
    public function destroy(Request $request, $id)
    {
        $project = Project::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$project) {
            return response()->json([
                'message' => 'Proyecto no encontrado o no autorizado'
            ], 404);
        }

        $project->tasks()->delete();

        $project->delete();

        return response()->json([
            'message' => 'Proyecto eliminado correctamente'
        ]);
    }
}
