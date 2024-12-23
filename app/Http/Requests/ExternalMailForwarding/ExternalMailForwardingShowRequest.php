<?php

namespace App\Http\Requests\ExternalMailForwarding;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExternalMailForwardingShowRequest extends FormRequest
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
            'field'   => ['in:agenda_number,letter_number,letter_date'],
            'order'   => ['in:asc,desc'],
            'perPage' => ['numeric'],
        ];
    }
}
