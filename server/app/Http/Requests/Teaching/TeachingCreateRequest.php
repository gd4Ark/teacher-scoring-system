<?php

namespace App\Http\Requests\Teaching;

use App\Models\Teaching;
use App\Http\Requests\Request;

class TeachingCreateRequest extends Request
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
        $input = $this->request->all();
        return [
            'group_id' => 'required|exists:groups,id',
            'subject_id' => ['required','exists:subjects,id',function ($attribute, $value, $fail) use ($input) {
                $hasExists = Teaching::query()->where([
                    'group_id' => $input['group_id'],
                    'subject_id' => $value,
                ])->exists();
                if ($hasExists) {
                    $fail('不可添加相同科目!！');
                }
            }],
            'teacher_id' => 'required|exists:teachers,id',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'group_id.required' => '必须指定班级ID！',
            'group_id.exists' => '该班级不存在！',
            'subject_id.required' => '必须指定科目ID！',
            'subject_id.exists' => '该科目不存在！',
            'teacher_id.required' => '必须指定教师ID！',
            'teacher_id.exists' => '该教师不存在！',
        ];
    }
}
