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
     * @return array
     */
    public function option(){
        return [
            'label' => $this->name,
            'value' => $this->id,
        ];
    }
}