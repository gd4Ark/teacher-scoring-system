<?php

namespace App\Rules;


class StudentRule
{
    /**
     * @param $row
     * @param array $array
     * @return array
     */
    static public function rules($row = null,$array = ['name','complete']){
        $data = [];
        $rules = [
            'name' => [
                'sometimes',
                'required',
                'min:1',
                'max:16',
            ],
            'complete' =>  'boolean',
        ];
        foreach($array as $item){
            $data[$item] =  $rules[$item];
        }
        return $data;
    }

    /**
     * @return array
     */
    static public function message(){
        return [

        ];
    }
}