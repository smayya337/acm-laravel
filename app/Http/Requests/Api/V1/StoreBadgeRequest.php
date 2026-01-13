<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreBadgeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30|unique:badges',
            'description' => 'nullable|string',
            'color' => 'required|string|in:blue,indigo,purple,pink,red,orange,yellow,green,teal,cyan,black,white,gray,gray-dark'
        ];
    }
}
