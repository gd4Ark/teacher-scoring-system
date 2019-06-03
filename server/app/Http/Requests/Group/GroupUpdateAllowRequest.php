<?php

namespace App\Http\Requests\Group;

use App\Http\Requests\Request;

class GroupUpdateAllowRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'allow' => 'required|boolean',
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