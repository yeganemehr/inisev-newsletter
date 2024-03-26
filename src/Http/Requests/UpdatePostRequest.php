<?php

namespace Inisev\Newsletter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'sometimes', 'string'],
            'description' => ['required', 'sometimes', 'string'],
            'url' => ['required', 'sometimes', 'url'],
            'resend' => ['required', 'boolean'],
        ];
    }
}
