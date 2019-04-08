<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

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

    public function rules($array = ['name','complete']){
        $data = [];
        $rules = [
            'name' => [
                'sometimes',
                'required',
                'min:1',
                'max:16',
//                Rule::unique('students')->ignore($this->id)->where(function ($query){
//                    return $query->where('group_id',$this->group_id)->get()->count();
//                })
            ],
            'complete' =>  'boolean',
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