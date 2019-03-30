<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Group extends Model
{

    protected $fillable = [
        'name',
        'allow',
        'meta'
    ];
    protected $casts = [
        'meta' => 'array'
    ];

    public function students()
    {
        return $this->hasOne('App\Student','group_id','id');
    }
}