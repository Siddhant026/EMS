<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id', 'address', 'pincode', 'dob', 'date_of_joining', 'position_id'
    ];

    public function position() {
        return $this->hasOne('App\Position', 'position_id');
    }

    // public function user() {
    //     // return $this->hasOne('App\User', 'user_id');
    //     return $this->hasOne(User::class);
    // }
}
