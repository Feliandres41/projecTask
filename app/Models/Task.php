<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    protected $fillable = [
        'project_id', 'title', 'due_date', 'is_completed'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

