<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
            'comment' => 'sometimes|string',
            'rating' => 'sometimes|integer|min:1|max:5',
            'checked' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'rating.integer' => 'Reyting butun son bo\'lishi kerak',
            'rating.min' => 'Reyting kamida 1 bo\'lishi kerak',
            'rating.max' => 'Reyting ko\'pi bilan 5 bo\'lishi mumkin',
        ];
    }
}
