<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Subject extends Model
{
    protected $fillable = [
        'name',
        'meta'
    ];
    protected $casts = [
        'meta' => 'array'
    ];
}