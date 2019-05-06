<?php

namespace App\Models;

class Student extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'group_id',
        'complete',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group(){
        return $this->belongsTo('App\Models\Group');
    }
}