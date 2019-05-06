<?php

namespace App\Rules;


class ArchiveRule
{
    /**
     * @param $row
     * @param array $array
     * @return array
     */
    static public function rules($row = null,$array = ['name']){
        $data = [];
        $rules = [
            'name' => [
                'sometimes',
                'required',
                'string',
                'min:1',
                'max:60',
                'unique:archives' . ($row ? ',name,' . $row->id : ''),
            ],
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