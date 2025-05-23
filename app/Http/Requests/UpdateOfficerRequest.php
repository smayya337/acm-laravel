<?php

namespace App\Http\Requests;

use App\Models\Officer;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOfficerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->officer);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'exists:users,username',
            'position' => 'string',
            'year' => 'integer|min:1819|max:' . date('Y'),
            'sort_order' => 'integer|min:0',
        ];
    }
}
