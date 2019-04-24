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

    public function group(){
        return $this->belongsTo('App\Models\Group');
    }

    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }

    public function teacher(){
        return $this->belongsTo('App\Models\Teacher');
    }

    public function data(){
        return [
            'id' => $this->id,
            'group' => $this->group->option(),
            'subject' => $this->subject->option(),
            'teacher' => $this->teacher->option(),
        ];
    }

}