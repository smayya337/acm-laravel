<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBadgeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $badgeId = $this->route('badge');

        return [
            'name' => 'required|string|max:30|unique:badges,name,' . $badgeId,
            'description' => 'nullable|string',
            'color' => 'required|string|in:blue,indigo,purple,pink,red,orange,yellow,green,teal,cyan,black,white,gray,gray-dark'
        ];
    }
}
