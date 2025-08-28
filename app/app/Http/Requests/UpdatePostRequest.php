<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title'   => 'required|string|max:50',
            'content' => 'required|string|max:2000',
            'price'   => 'required|integer|min:0',
            'image'   => 'nullable|string',
        ];
    }

    public function attributes(): array {
        return [
            'title' => 'タイトル',
            'price' => '金額',
            'content' => '内容',
            'image' => '画像',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です',
            'title.max' => 'タイトルは50文字以内で入力してください',
            'content.required' => '内容は必須です',
            'content.max' => '内容は2000文字以内で入力してください',
            'price.required' => '金額は必須です',
            'price.integer' => '金額は整数で入力してください',
            'price.min' => '金額は0以上で入力してください',
            'image.string' => '画像パスは文字列で入力してください',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Log::error('UpdatePostRequest validation failed', [
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all(),
            'user_id' => auth()->id()
        ]);
        
        throw new \Illuminate\Validation\ValidationException($validator);
    }
}