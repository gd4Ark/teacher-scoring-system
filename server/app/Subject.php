<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Subject extends Model
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
            'name' => 'sometimes|required|string|min:1|max:32|unique:subjects,name,' . $this->id,
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