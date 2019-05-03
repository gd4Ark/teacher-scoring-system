<?php

namespace App\Models;

class Subject extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
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
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function teachings()
    {
        return $this->hasMany('App\Models\Teaching');
    }

    /**
     * @return array
     */
    public function getTeachings(){
        $teachings = [];
        foreach ($this->teachings as $teaching){
            $teachings[] = [
                'group_name' => $teaching->group->name,
                'teacher_name' => $teaching->teacher->name,
            ];
        }
        return $teachings;
    }

    /**
     * @param array $array
     * @return array
     */
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

    /**
     * @return array
     */
    public function ruleMessage(){
        return [
            'name.unique' => 'Name already exists',
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