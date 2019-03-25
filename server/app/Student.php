<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Student extends Model
{
    protected $fillable = [
        'name',
        'group_id',
        'complete',
        'meta'
    ];
    protected $casts = [
        'meta' => 'array'
    ];
}