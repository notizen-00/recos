<?php

namespace App\Http\Requests\ExternalMail;

use Illuminate\Foundation\Http\FormRequest;

class ExternalMailStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'agenda_date'    => 'required|date',
            'letter_number'  => 'required',
            'letter_date'    => 'required|date',
            'external_type'  => 'required',
            'classification' => 'required',
            'priority'       => 'required',
            'subject'        => 'required',
            'from_user'      => 'required',
            'from_ext'       => 'required',
            'forwarded_to'   => 'required',
            'forwarded_date' => 'required|date',
            'file_pdf'       => 'required|file|mimes:pdf|max:10240',
            'description'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'This field is required'
        ];
    }
}