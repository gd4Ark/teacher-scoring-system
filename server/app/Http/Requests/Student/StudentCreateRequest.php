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
            'names' => 'required|string|max:16',
            'group_id' => 'required|exists:groups,id',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '名称字段为必填',
            'name.unique' => '该名称已占用！',
            'name.max' => '名称长度不可超过16个字符',
            'group_id.required' => '必须指定班级ID',
            'group_id.exists' => '该班级不存在！',
        ];
    }
}