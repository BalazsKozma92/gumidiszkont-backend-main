<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    /**
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 
                [
                    'required',
                    'max:2000'
                ],
            'content' => 
                [
                    'required',
                    'string'
                ],
            'published' => 
                [
                    'required',
                    'boolean'
                ],
        ];
    }
}