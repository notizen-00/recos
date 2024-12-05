<?php

namespace App\Http\Requests\OutgoingMail;

use Illuminate\Foundation\Http\FormRequest;

class OutgoingMailVerifikasiRequest extends FormRequest
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
            'outgoing_mail_id' => 'required|integer',
            'to.id' => 'required_if:status.value,1|integer',
            'note' => 'nullable',
            'status.value' => 'required|boolean',
            'is_confirmed' => 'nullable|boolean',
        ];
    }
}
