<?php

namespace App\Http\Requests\Archive;

use App\Http\Requests\Request;

class ArchiveCreateRequest extends Request
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
            'name' => 'required|string|max:60|unique:archives',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'names.required' => '名称字段为必填！',
            'names.unique' => '该名称已占用！',
        ];
    }
}
