<?php

namespace App\Http\Requests\SubType;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:50|',
            'letter_format' => 'required | string | max:50',
            'bod'           => 'required',
            'form_type'     => 'required',
            'ttd_type'      => 'required',
            'type_id'       => 'required | integer | max:3',
        ];
    }
}
