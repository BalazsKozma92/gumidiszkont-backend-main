<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
            'name' => 
                [
                    'required',
                    'string'
                ],
            'email' => 
                [
                    'required',
                    'string'
                ],
            'contactMessage' => 
                [
                    'required',
                    'string'
                ],
        ];
    }
}