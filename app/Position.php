<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name', 'dept_id'
    ];

    public function department() {
        return $this->belongsTo('App\department', 'dept_id');
    }
}
