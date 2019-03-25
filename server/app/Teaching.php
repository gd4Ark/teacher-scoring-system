<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Teaching extends Model
{
    protected $fillable = [
        'name',
        'group_id',
        'teacher_id',
        'subject_id',
        'meta'
    ];
    protected $casts = [
        'meta' => 'array'
    ];
}