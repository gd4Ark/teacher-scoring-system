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
     * @param $name
     */
    public function setNameAttribute($name){
        $this->attributes['name'] = trim($name);
    }

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
     * @return array
     */
    public function option(){
        return [
            'label' => $this->name,
            'value' => $this->id,
        ];
    }
}