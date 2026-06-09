<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => ['required', 'max:20'],
            'postal_code' => ['required', 'max:8'],
            'address' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.max' => '名前は20文字以内で入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.max' => '郵便番号は8文字以内で入力してください',
            'address.required' => '住所を入力してください',
            'image.image' => 'プロフィール画像は画像ファイルを選択してください',
            'image.mimes' => 'プロフィール画像はJPEGまたはPNG形式でアップロードしてください',
        ];
    }
}
