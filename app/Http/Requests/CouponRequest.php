<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code' => 
                [
                    'required',
                    'string'
                ],
            'type' => 
                [
                    'required',
                    'string'
                ],
            'discount' => 
                [
                    'required',
                    'numeric'
                ],
            'active' => 
                [
                    'required',
                    'boolean'
                ],
            'event_start' =>
                [
                    'required',
                    'date_format:Y-m-d'
                ],
            'event_end' =>
                [
                    'required',
                    'date_format:Y-m-d'
                ],
        ];
    }
}