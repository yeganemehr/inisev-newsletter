<?php

namespace Inisev\Newsletter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Inisev\Newsletter\Models\Post;

class StorePostRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'local_id' => [
                'required',
                'string',
                Rule::unique(Post::class)->where('website_id', $this->route('website')),
            ],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'url' => ['required', 'url'],
        ];
    }
}
