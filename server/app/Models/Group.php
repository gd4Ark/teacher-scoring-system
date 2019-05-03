<?php

namespace App\Models;

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
     * @var array 
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function teachings()
    {
        return $this->hasMany('App\Models\Teaching');
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

    /**
     * @return array
     */
    public function option(){
        return [
            'label' => $this->name,
            'value' => $this->id,
        ];
    }
}