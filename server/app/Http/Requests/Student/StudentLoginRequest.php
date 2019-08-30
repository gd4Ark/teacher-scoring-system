<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\Request;
use App\Models\Student;

class StudentLoginRequest extends Request
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
            'user_id' => ['required','exists:students,id',function ($attribute, $value, $fail) {
                $student = Student::query()->findOrFail($value);
                if (!$student->group->allow) {
                    $fail('该班级禁止评分！');
                } elseif ($student->complete) {
                    $fail('您已提交！');
                }
            }],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.exists' => '该学生不存在',
        ];
    }
}
