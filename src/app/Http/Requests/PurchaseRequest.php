<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Address;

class PurchaseRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'payment_method' => 'required|in:card,konbini',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $address = Address::where('user_id', auth()->id())->first();

            if (!$address || !$address->postal_code || !$address->address) {
                $validator->errors()->add('address', '配送先を入力してください');
            }
        });
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください',
            'payment_method.in' => '正しい支払い方法を選択してください',
        ];
    }
}
