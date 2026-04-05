<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
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
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'learning_center_id' => 'required|integer|exists:learning_centers,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Fan nomi kiritilishi shart',
            'price.numeric' => 'Narx raqam bo\'lishi kerak',
            'price.min' => 'Narx 0 dan katta bo\'lishi kerak',
            'learning_center_id.exists' => 'Bunday o\'quv markazi topilmadi',
        ];
    }
}
