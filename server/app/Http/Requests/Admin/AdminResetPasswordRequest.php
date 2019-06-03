<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AdminResetPasswordRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string',
            'password_current' => 'required|string',
            'password_confirm' => 'require|string',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
}
