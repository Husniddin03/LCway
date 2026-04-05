<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['user', 'admin', 'moderator'])],
            'status' => ['required', Rule::in(['active', 'inactive', 'banned'])],
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|string|max:500',
            'checked' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Ism kiritilishi shart',
            'email.required' => 'Email kiritilishi shart',
            'email.email' => 'Email formati noto\'g\'ri',
            'email.unique' => 'Bu email allaqachon ishlatilmoqda',
            'password.required' => 'Parol kiritilishi shart',
            'password.min' => 'Parol kamida 8 ta belgidan iborat bo\'lishi kerak',
            'role.required' => 'Rol tanlanishi shart',
            'role.in' => 'Rol noto\'g\'ri',
            'status.required' => 'Status tanlanishi shart',
            'status.in' => 'Status noto\'g\'ri',
        ];
    }
}
