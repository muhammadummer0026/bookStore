<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'books' => 'required|array',
            'quantity' => 'required|integer|min:1',
            'email' => 'required|email',
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'billing_address' => 'required|string',
            'grand_total' => 'required|numeric|min:0',

        ];
    }
}
