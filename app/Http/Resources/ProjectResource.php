<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'is_archived' => $this->is_archived,
            'tasks'       => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
