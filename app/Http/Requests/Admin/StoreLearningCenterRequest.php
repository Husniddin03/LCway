<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLearningCenterRequest extends FormRequest
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
            'description' => 'required|string',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'telegram' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'region_id' => 'required|integer',
            'district_id' => 'required|integer',
            'users_id' => 'required|integer|exists:users,id',
            'checked' => 'sometimes|boolean',
            'premium' => 'sometimes|boolean',
            'premium_until' => 'nullable|date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nomi kiritilishi shart',
            'description.required' => 'Tavsif kiritilishi shart',
            'address.required' => 'Manzil kiritilishi shart',
            'phone.required' => 'Telefon raqami kiritilishi shart',
            'email.email' => 'Email formati noto\'g\'ri',
            'users_id.exists' => 'Bunday foydalanuvchi topilmadi',
            'premium_until.date' => 'Sana formati noto\'g\'ri',
        ];
    }
}
