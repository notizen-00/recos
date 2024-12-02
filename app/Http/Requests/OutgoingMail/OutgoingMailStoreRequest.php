<?php

namespace App\Http\Requests\OutgoingMail;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OutgoingMailStoreRequest extends FormRequest
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
            'priority.id'       => 'required|integer|max:3|',
            'classification.id' => 'required|integer|max:3|',
            'sub_type_id'       => 'required|integer',
            'sign_user.id'      => 'required',
            'subject'           => 'required|string|max:255',
            'mail_date'         => 'required|date',
            'mail_place'        => 'required_if:form_type,1|string',
            'to.id'             => 'required|int',
            'attachment'        => 'required_if:form_type,2|string|max:255',
            'attachment_file'   => 'required_if:form_type,2|file|mimes:pdf|max:10240',
            'content'           => 'required_if:form_type,2|string',
            'recipients'        => 'required_if:form_type,2',
            'org_subject_id'    => 'required_if:form_type,2',
        ];
    }

    public function messages()
    {
        return [
            'required_if' => 'This field is required',
            'required'    => 'This field is required'
        ];
    }
}
