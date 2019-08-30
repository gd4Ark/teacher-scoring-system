<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'password_current' => 'required|min:6|max:18',
            'password' => 'required|min:6|max:18|confirmed',
            'password_confirmation' => 'required|min:6|max:18'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'password_current.required' => '旧密码为必填',
            'password_current.min' => '旧密码长度至少在6-18个字符之间',
            'password_current.max' => '旧密码长度至少在6-18个字符之间',
            'password.required' => '密码为必填',
            'password.min' => '密码长度至少在6-18个字符之间',
            'password.max' => '密码长度至少在6-18个字符之间',
            'password.confirmed' => '密码不一致',
        ];
    }
}
