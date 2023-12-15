<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNumberRequest extends FormRequest
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
            'number_id' => 'string',
            'waba_id' => 'string',
            'token' => 'string',
            'api_version' => 'string',
            'name' => 'string',
            'status' => 'string|in:active,inactive,test',
            'save_messages' => 'boolean',
            'save_media' => 'boolean'
        ];
    }
}
