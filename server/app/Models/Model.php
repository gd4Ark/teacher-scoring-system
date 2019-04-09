<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @param array $array
     * @return array
     */
    public function rules($array = []){
        $data = [];
        $rules = [];
        foreach($array as $item){
            $data[$item] =  $rules[$item];
        }
        return $data;
    }

    /**
     * @return array
     */
    public function ruleMessage(){
        return [

        ];
    }
}