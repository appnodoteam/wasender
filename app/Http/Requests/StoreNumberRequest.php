<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNumberRequest extends FormRequest
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
        // regex, numbers only
        return [
            'id' => 'required|integer',
            'number_id' => 'required|string',
            'waba_id' => 'required|string',
            'token' => 'required|string',
            'api_version' => 'required|string',
            'name' => 'required|string',
            'status' => 'required|string|in:active,inactive,test',
            'save_messages' => 'required|boolean',
            'save_media' => 'required|boolean'
        ];
    }
}
