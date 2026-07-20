<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'emp_name' => 'required',
            'emp_id' => 'required',
            'emp_department' => 'required',
            'leave_type' => 'required',
            'leave_start' => 'required|date',
            'leave_end' => 'required|date',
            'leave_reason' => 'required',
            'leave_uuid' => 'nullable'
        ];
    }
}
