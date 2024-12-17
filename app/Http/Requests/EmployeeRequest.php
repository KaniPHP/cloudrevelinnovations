<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('employees')->ignore($this->employee ? $this->employee->id : null),
            ],
            'dob' => 'required|date_format:d/m/Y',
            'doj' => 'required|date_format:d/m/Y',
        ];
    }
    
    /**
     * Get the custom attributes for the validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'dob' => 'date of birth',
            'doj' => 'date of joining',
        ];
    }
}
