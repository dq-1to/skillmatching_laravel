<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
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
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:2000',
            'tel' => 'nullable|regex:/^[0-9]{10,15}$/',
            'email' => 'required|email',
            'due_date' => 'nullable|date|after:today',
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
            'post_id.required' => '投稿IDは必須です',
            'post_id.exists' => '指定された投稿が存在しません',
            'content.required' => '依頼内容は必須です',
            'content.max' => '依頼内容は2000文字以内で入力してください',
            'tel.regex' => '電話番号は10桁から15桁の数字で入力してください',
            'email.required' => 'メールアドレスは必須です',
            'email.email' => '有効なメールアドレスを入力してください',
            'due_date.date' => '有効な日付を入力してください',
            'due_date.after' => '期限は今日以降の日付を入力してください',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'post_id' => '投稿ID',
            'content' => '依頼内容',
            'tel' => '電話番号',
            'email' => 'メールアドレス',
            'due_date' => '期限',
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
        \Log::error('StoreRequestRequest validation failed', [
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all(),
            'user_id' => auth()->id()
        ]);
        
        throw new \Illuminate\Validation\ValidationException($validator);
    }
}
