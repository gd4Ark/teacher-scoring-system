<?php

namespace App\Http\Requests\Subject;

use App\Http\Requests\Request;

class SubjectCreateRequest extends Request
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