<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $fillable = [
        'name',
        'allow',
        'meta'
    ];
    protected $casts = [
        'meta' => 'array'
    ];

    public function students()
    {
        return $this->hasOne('App\Student','group_id','id');
    }

    public function rules($array = ['name','allow']){
        $data = [];
        $rules = [
            'name' => 'sometimes|required|string|min:1|max:32|unique:groups,name,' . $this->id,
            'allow' => 'boolean'
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