<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Teacher extends Model
{
    protected $fillable = [
        'name',
        'meta'
    ];
    protected $casts = [
        'meta' => 'array'
    ];

    public function rules($array = ['name']){
        $data = [];
        $rules = [
            'name' => 'unique:teachers,name,' . $this->id,
        ];
        foreach($array as $item){
            $data[$item] =  $rules[$item];
        }
        return $data;
    }

    public function ruleMessage(){
        return [
            'name.unique' => 'Name already exists',
        ];
    }
}