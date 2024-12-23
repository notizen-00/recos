<?php

namespace App\Http\Requests\ExternalMailForwarding;

use Illuminate\Foundation\Http\FormRequest;

class ExternalMailForwardingStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recipients'        => 'required|array|min:2',
            'follow_up_type'    => 'required',
            'follow_up_message' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'This field is required'
        ];
    }
}