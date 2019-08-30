<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\Request;

class StudentCreateRequest extends Request
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
            'group_id' => 'required|exists:groups,id',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'names.required' => '名称字段为必填',
            'group_id.required' => '必须指定班级ID',
            'group_id.exists' => '该班级不存在！',
        ];
    }
}
