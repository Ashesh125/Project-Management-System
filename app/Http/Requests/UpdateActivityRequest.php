<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
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
            'id' => 'required|exists:activities,id',
            'name' => 'required|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'required|max:255',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'No Such Activity Found',
            'name.required' => 'A name is required',
            'start_date.required' => 'Please insert a valid start date',
            'end_date.required' => 'Please insert a valid end date',
            'description.required' => 'A description is required',
            'user_id.required' => 'There is no such User',
            'project_id' => 'required|exists:projects,id'
        ];
    }
}
