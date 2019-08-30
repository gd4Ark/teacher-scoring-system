<?php

namespace App\Models;

class Score extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'group_id',
        'student_id',
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
    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}
