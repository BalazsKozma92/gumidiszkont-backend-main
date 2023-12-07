<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_group' => 
                [
                    'nullable',
                    'numeric'
                ],
            'quantity' => 
                [
                    'required',
                    'numeric'
                ],
            'image' => 
                [
                    'nullable',
                    'image'
                ],
            'price' => 
                [
                    'required',
                    'numeric'
                ],
            'sale_price' => 
                [
                    'required',
                    'numeric'
                ],
            'sale_active' => 
                [
                    'required',
                    'boolean'
                ],
            'description' => 
                [
                    'nullable',
                    'string'
                ],
            'published' => 
                [
                    'required',
                    'boolean'
                ],
            'product_group' => 
                [
                    'required',
                    'numeric'
                ],
        ];
    }
}