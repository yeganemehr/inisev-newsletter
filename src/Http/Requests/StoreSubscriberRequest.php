<?php

namespace Inisev\Newsletter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Inisev\Newsletter\Models\Subscriber;

class StoreSubscriberRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique(Subscriber::class)->where('website_id', $this->route('website')),
            ],
            'name' => ['required', 'string'],
        ];
    }
}
