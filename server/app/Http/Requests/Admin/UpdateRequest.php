<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'number' => 'required|string|max:16',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名字必填',
            'name.string' => '名字为字符串',
            'number.required' => '账号必填',
            'number.string' => '账号字符串',
            'number.max' => '账号最大长度为16',
        ];
    }
}
