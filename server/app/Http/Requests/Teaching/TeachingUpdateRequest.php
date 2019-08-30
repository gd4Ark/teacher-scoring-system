<?php

namespace App\Http\Requests\Teaching;

use App\Http\Requests\Request;
use App\Models\Teaching;

class TeachingUpdateRequest extends Request
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
        $id = $this->routeParam('id');
        return [
            'subject_id' => ['required','exists:subjects,id',function ($attribute, $value, $fail) use ($id) {
                $hasExists = Teaching::query()->where([
                    'group_id' => Teaching::query()->findOrFail($id)->group->id,
                    'subject_id' => $value,
                ])->where('id', '!=', $id)->exists();
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
            'subject_id.required' => '必须指定科目ID！',
            'subject_id.exists' => '该科目不存在！',
            'teacher_id.required' => '必须指定教师ID！',
            'teacher_id.exists' => '该教师不存在！',
        ];
    }
}
