<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

class DepartmentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isStoring = $this->routeIs('department.store');
        $fieldPresent = $isStoring ? 'required' : 'sometimes';
        return [
            'name' => [$fieldPresent, 'string', (new Unique('departments'))->ignore($this->route('department'))]
        ];
    }
}
