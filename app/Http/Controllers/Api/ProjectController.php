<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', auth()->id())->get();
        return ProjectResource::collection($projects);
    }


    public function store(StoreProjectRequest $request)
    {
        $project = Project::create([
            'user_id'     => auth()->id(),
            'name'        => $request->name,
            'description' => $request->description,
            'is_archived' => false
        ]);

        return new ProjectResource($project);
    }


    public function show(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return new ProjectResource($project->load('tasks'));
    }


    public function update(StoreProjectRequest $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $project->update($request->validated());

        return new ProjectResource($project);
    }


    public function destroy(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $project->delete();

        return response()->json(['message' => 'Proyecto eliminado']);
    }
}
