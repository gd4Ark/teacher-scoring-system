<?php

namespace App\Rules;


class GroupRule
{
    /**
     * @param $row
     * @param array $array
     * @return array
     */
    static public function rules($row = null, $array = ['name', 'allow'])
    {
        $data = [];
        $rules = [
            'name' => [
                'sometimes',
                'required',
                'string',
                'min:1',
                'max:30',
                'unique:groups' . ($row ? ',name,' . $row->id : ''),
            ],
            'allow' => 'boolean'
        ];
        foreach ($array as $item) {
            $data[$item] = $rules[$item];
        }
        return $data;
    }

    /**
     * @return array
     */
    static public function message()
    {
        return [

        ];
    }
}