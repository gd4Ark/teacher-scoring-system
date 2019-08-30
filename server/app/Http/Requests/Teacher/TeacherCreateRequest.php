<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\Request;

class TeacherCreateRequest extends Request
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
            'names' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'names.required' => '名称字段为必填',
        ];
    }
}
