<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password' => 'sometimes|string|min:8',
            'role' => ['sometimes', Rule::in(['user', 'admin', 'moderator'])],
            'status' => ['sometimes', Rule::in(['active', 'inactive', 'banned'])],
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
            'name.string' => 'Ism matn bo\'lishi kerak',
            'email.email' => 'Email formati noto\'g\'ri',
            'email.unique' => 'Bu email allaqachon ishlatilmoqda',
            'password.min' => 'Parol kamida 8 ta belgidan iborat bo\'lishi kerak',
            'role.in' => 'Rol noto\'g\'ri',
            'status.in' => 'Status noto\'g\'ri',
        ];
    }
}
