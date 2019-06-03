<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\Request;

class StudentUpdateRequest extends Request
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
            'name' => 'required|string|max:64',
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