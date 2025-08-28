<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute は受諾されなければなりません。',
    'active_url' => ':attribute は有効なURLではありません。',
    'after' => ':attribute は :date 以降でなければなりません。',
    'after_or_equal' => ':attribute は :date 以降または同じ日付でなければなりません。',
    'alpha' => ':attribute は英字のみで構成されていなければなりません。',
    'alpha_dash' => ':attribute は英字、数字、ダッシュ（-）、アンダースコア（_）のみで構成されていなければなりません。',
    'alpha_num' => ':attribute は英字と数字のみで構成されていなければなりません。',
    'array' => ':attribute は配列でなければなりません。',
    'before' => ':attribute は :date 以前でなければなりません。',
    'before_or_equal' => ':attribute は :date 以前または同じ日付でなければなりません。',
    'between' => [
        'numeric' => ':attribute は :min から :max の間でなければなりません。',
        'file' => ':attribute は :min から :max キロバイトの間でなければなりません。',
        'string' => ':attribute は :min から :max 文字の間でなければなりません。',
        'array' => ':attribute は :min から :max 個の要素を含んでいなければなりません。',
    ],
    'boolean' => ':attribute は true または false でなければなりません。',
    'confirmed' => ':attribute の確認が一致しません。',
    'date' => ':attribute は有効な日付ではありません。',
    'date_equals' => ':attribute は :date と同じ日付でなければなりません。',
    'date_format' => ':attribute は :format の形式ではありません。',
    'different' => ':attribute と :other は異なっていなければなりません。',
    'digits' => ':attribute は :digits 桁でなければなりません。',
    'digits_between' => ':attribute は :min から :max 桁の間でなければなりません。',
    'dimensions' => ':attribute は無効な画像サイズです。',
    'distinct' => ':attribute は重複した値を含んでいます。',
    'email' => ':attribute は有効なメールアドレスではありません。',
    'ends_with' => ':attribute は次のいずれかで終わっていなければなりません: :values.',
    'exists' => '選択された :attribute は無効です。',
    'file' => ':attribute はファイルでなければなりません。',
    'filled' => ':attribute は値を持っていなければなりません。',
    'gt' => [
        'numeric' => ':attribute は :value より大きくなければなりません。',
        'file' => ':attribute は :value キロバイトより大きくなければなりません。',
        'string' => ':attribute は :value 文字より大きくなければなりません。',
        'array' => ':attribute は :value 個より多くの要素を含んでいなければなりません。',
    ],
    'gte' => [
        'numeric' => ':attribute は :value 以上でなければなりません。',
        'file' => ':attribute は :value キロバイト以上でなければなりません。',
        'string' => ':attribute は :value 文字以上でなければなりません。',
        'array' => ':attribute は :value 個以上の要素を含んでいなければなりません。',
    ],
    'image' => ':attribute は画像でなければなりません。',
    'in' => '選択された :attribute は無効です。',
    'in_array' => ':attribute は :other に存在しません。',
    'integer' => ':attribute は整数でなければなりません。',
    'ip' => ':attribute は有効なIPアドレスではありません。',
    'ipv4' => ':attribute は有効なIPv4アドレスではありません。',
    'ipv6' => ':attribute は有効なIPv6アドレスではありません。',
    'json' => ':attribute は有効なJSON文字列ではありません。',
    'lt' => [
        'numeric' => ':attribute は :value より小さくなければなりません。',
        'file' => ':attribute は :value キロバイトより小さくなければなりません。',
        'string' => ':attribute は :value 文字より小さくなければなりません。',
        'array' => ':attribute は :value 個より少ない要素を含んでいなければなりません。',
    ],
    'lte' => [
        'numeric' => ':attribute は :value 以下でなければなりません。',
        'file' => ':attribute は :value キロバイト以下でなければなりません。',
        'string' => ':attribute は :value 文字以下でなければなりません。',
        'array' => ':attribute は :value 個以下の要素を含んでいなければなりません。',
    ],
    'max' => [
        'numeric' => ':attribute は :max より大きくなければなりません。',
        'file' => ':attribute は :max キロバイトより大きくなければなりません。',
        'string' => ':attribute は :max 文字より大きくなければなりません。',
        'array' => ':attribute は :max 個より多くの要素を含んでいなければなりません。',
    ],
    'mimes' => ':attribute は次のタイプのファイルでなければなりません: :values.',
    'mimetypes' => ':attribute は次のタイプのファイルでなければなりません: :values.',
    'min' => [
        'numeric' => ':attribute は :min 以上でなければなりません。',
        'file' => ':attribute は :min キロバイト以上でなければなりません。',
        'string' => ':attribute は :min 文字以上でなければなりません。',
        'array' => ':attribute は :min 個以上の要素を含んでいなければなりません。',
    ],
    'not_in' => '選択された :attribute は無効です。',
    'not_regex' => ':attribute の形式が無効です。',
    'numeric' => ':attribute は数値でなければなりません。',
    'password' => 'パスワードが一致しません。',
    'present' => ':attribute は必須項目です。',
    'regex' => ':attribute の形式が無効です。',
    'required' => ':attribute は必須項目です。',
    'required_if' => ':attribute は必須項目です（ :other が :value の場合）。', 
    'required_unless' => ':attribute は必須項目です（ :other が :values の場合除く）。', 
    'required_with' => ':attribute は必須項目です（ :values がある場合）。',
    'required_with_all' => ':attribute は必須項目です（ :values がある場合）。',
    'required_without' => ':attribute は必須項目です（ :values がない場合）。',
    'required_without_all' => ':attribute は必須項目です（ :values がすべてない場合）。',
    'same' => ':attribute と :other は同じでなければなりません。',
    'size' => [
        'numeric' => ':attribute は :size でなければなりません。',
        'file' => ':attribute は :size キロバイトでなければなりません。',
        'string' => ':attribute は :size 文字でなければなりません。',
        'array' => ':attribute は :size 個の要素を含んでいなければなりません。',
    ],
    'starts_with' => ':attribute は次のいずれかで始まっていなければなりません: :values.',
    'string' => ':attribute は文字列でなければなりません。',
    'timezone' => ':attribute は有効なタイムゾーンでなければなりません。',
    'unique' => ':attribute はすでに存在します。',
    'uploaded' => ':attribute のアップロードに失敗しました。',
    'url' => ':attribute の形式が無効です。',
    'uuid' => ':attribute は有効なUUIDではありません。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => ':attribute は :value でなければなりません。',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'title' => 'タイトル',
        'content' => '内容',
        'price' => '価格',
        'image' => '画像',
    ],

];
