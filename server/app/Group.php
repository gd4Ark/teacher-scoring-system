<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'allow',
        'meta'
    ];
    /**
     * @var array
     */
    protected $casts = [
        'meta' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function students()
    {
        return $this->hasOne('App\Student','group_id','id');
    }

    /**
     * @param array $array
     * @return array
     */
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

    /**
     * @return array
     */
    public function ruleMessage(){
        return [

        ];
    }
}