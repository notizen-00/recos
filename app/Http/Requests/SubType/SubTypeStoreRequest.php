<?php

namespace App\Http\Requests\SubType;

use App\Models\SubTypes;
use Illuminate\Foundation\Http\FormRequest;

class SubTypeStoreRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|unique:' . SubTypes::class,
            'letter_format' => 'required|string|max:50',
            'type_id' => 'required|integer|max:3',
        ];
    }
}
