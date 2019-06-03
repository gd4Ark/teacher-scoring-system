<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\Request;
use App\Models\Student;

class StudentSubmitRequest extends Request
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
            'scores' => 'required|array',
            'user_id' => ['required','exists:students,id',function($attribute,$value,$fail){
                $student = Student::query()->findOrFail($value);
                if (!$student->groups->allow){
                    $fail('该班级禁止评分！');
                }else if ($student->complete){
                    $fail('禁止重复提交！');
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