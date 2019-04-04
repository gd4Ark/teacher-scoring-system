<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Student extends Model
{
    protected $fillable = [
        'name',
        'group_id',
        'complete',
        'meta'
    ];
    protected $casts = [
        'meta' => 'array'
    ];

    public function rules($array = ['name']){
        $data = [];
        $rules = [

        ];
        foreach($array as $item){
            $data[$item] =  $rules[$item];
        }
        return $data;
    }

    public function ruleMessage(){
        return [

        ];
    }
}