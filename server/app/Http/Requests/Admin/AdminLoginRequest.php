<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AdminLoginRequest extends Request
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string',
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
