<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

class UserRequest extends FormRequest
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
        $isStoring = $this->routeIs('user.store');
        $fieldPresent = $isStoring ? 'required' : 'sometimes';
        return [
            'name' => [$fieldPresent, 'string', (new Unique('users'))->ignore($this->route('user'))],
            'email' => [$fieldPresent, 'email:rfc,dns', (new Unique('users'))->ignore($this->route('user'))]
        ];
    }
}
