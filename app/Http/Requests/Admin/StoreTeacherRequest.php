<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'bio' => 'nullable|string',
            'learning_center_id' => 'required|integer|exists:learning_centers,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Ism kiritilishi shart',
            'phone.required' => 'Telefon raqami kiritilishi shart',
            'email.email' => 'Email formati noto\'g\'ri',
            'learning_center_id.exists' => 'Bunday o\'quv markazi topilmadi',
        ];
    }
}
