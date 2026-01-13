<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfficerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'position' => 'required|string|max:30',
            'sort_order' => 'required|integer',
            'year' => 'required|integer',
            'user_id' => 'required|exists:users,id'
        ];
    }
}
