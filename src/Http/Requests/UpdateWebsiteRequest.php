<?php

namespace Inisev\Newsletter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Inisev\Newsletter\Models\Website;

class UpdateWebsiteRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'domain' => [
                'required',
                'sometimes',
                'regex:/^([a-z]+\.)+[a-z]{2,}/i',
                Rule::unique(Website::class)->ignore($this->route('website')),
            ],
            'title' => ['required', 'sometimes', 'string'],
        ];
    }
}
