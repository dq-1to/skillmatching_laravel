<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'price'   => 'required|integer|min:0',
            'content' => 'required|string|max:2000',
            'image'   => 'nullable|string', // 画像はパス文字列運用ならこのまま
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
            'content.max' => '内容は200文字以内で入力してください',
            'price.required' => '金額は必須です',
            'price.integer' => '金額は整数で入力してください',
            'price.min' => '金額は0以上で入力してください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '画像はJPEG、PNG、JPG、GIF形式で選択してください',
            'image.max' => '画像サイズは2MB以下で選択してください',
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
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Log::error('StorePostRequest validation failed', [
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all(),
            'user_id' => auth()->id()
        ]);
        
        throw new \Illuminate\Validation\ValidationException($validator);
    }
}
