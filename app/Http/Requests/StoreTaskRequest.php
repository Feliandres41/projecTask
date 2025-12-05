<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'title'      => 'required|min:3',
            'due_date'   => 'nullable|date'
        ];
    }
}
