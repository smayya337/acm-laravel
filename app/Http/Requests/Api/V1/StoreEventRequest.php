<?php

namespace App\Http\Requests\Api\V1;

use App\Helpers\FileHelper;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'location' => 'required|string|max:30',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:' . FileHelper::getMaxUploadSizeKB()
        ];
    }
}
