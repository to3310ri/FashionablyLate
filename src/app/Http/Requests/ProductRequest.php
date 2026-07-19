<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * 認証
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        $imageRule = $this->isMethod('post')
            ? ['required', 'file', 'mimes:png,jpg,jpeg']
            : ['nullable', 'file', 'mimes:png,jpg,jpeg'];

        return [
            'name' => [
                'required',
                'string',
            ],

            'price' => [
                'required',
                'integer',
                'between:0,10000',
            ],

            'image' => $imageRule,

            'seasons' => [
                'required',
                'array',
                'min:1',
            ],

            'seasons.*' => [
                'required',
                'string',
                'exists:seasons,name',
            ],

            'description' => [
                'required',
                'string',
                'max:120',
            ],
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください',

            'price.required' => '値段を入力してください',
            'price.integer' => '値段は数字で入力してください',
            'price.between' => '値段は0〜10000円以内で入力してください',

            'image.required' => '商品画像を選択してください',
            'image.mimes' => '画像はpng・jpg・jpeg形式でアップロードしてください',

            'seasons.required' => '季節を選択してください',
            'seasons.min' => '季節を1つ以上選択してください',

            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は120文字以内で入力してください',
        ];
    }
}