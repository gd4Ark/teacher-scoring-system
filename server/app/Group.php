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

    public function rules($array = ['name']){
        $data = [];
        $rules = [
            'name' => 'unique:groups,name,' . $this->id,
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