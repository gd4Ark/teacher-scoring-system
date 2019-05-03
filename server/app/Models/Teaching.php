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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(){
        return $this->belongsTo('App\Models\Teacher');
    }

    /**
     * @return array
     */
    public function data(){
        return [
            'id' => $this->id,
            'subject' => $this->subject->option(),
            'teacher' => $this->teacher->option(),
        ];
    }

}