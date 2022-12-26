<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role >= 1 ? true : false;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'due_date' => 'required|date',
            'description' => 'required|max:255',
            'status' => 'required|integer',
            'type' => 'required',
            'priority' => 'required',
            'user_id' => 'required|exists:users,id',
            'activity_id' => 'required|exists:activities,id'
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'A name is required :attribute :input',
            'start_date.required' => 'Please insert a valid start date',
            'end_date.required' => 'Please insert a valid end date',
            'description.required' => 'A description is required',
            'user_id.required' => 'There is no such User',
            'project_id.required' => 'There is no such Project'
        ];
    }
}
