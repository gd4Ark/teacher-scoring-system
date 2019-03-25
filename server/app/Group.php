<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Group extends Model
{
    protected $fillable = [
        'name',
        'code_main',
        'code_secondary',
        'meta'
    ];
    protected $casts = [
        'meta' => 'array'
    ];
}