<?php

namespace App\Models;

class Teaching extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'group_id',
        'teacher_id',
        'subject_id',
        'meta'
    ];
    /**
     * @var array
     */
    protected $casts = [
        'meta' => 'array'
    ];
}