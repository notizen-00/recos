<?php

namespace App\Http\Requests\OutgoingMail;

use App\Models\OutgoingMail;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'priority.id' => 'required|integer|max:3|',
            'classification.id' => 'required|integer|max:3|',
            'sub_type_id' => 'required|integer',
            'sign_user.id' => 'required',
            'subject' => 'required|string|max:255',
            'mail_date' => 'required|date',
            'mail_place' => 'required|string',
            'to.id' => 'required|int',
        ];
    }
}
