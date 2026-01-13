<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'username' => 'sometimes|string|unique:users,username,' . $userId,
            'email' => 'sometimes|email|unique:users,email,' . $userId,
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'bio' => 'nullable|string',
        ];
    }
}
