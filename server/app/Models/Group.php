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
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = trim($name);
    }

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
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getRelationCount($query)
    {
        return $query->withCount([
            'students',
            'students as complete_count' => function ($query) {
                $query->where('complete', 1);
            },
            'teachings',
        ]);
    }
}
