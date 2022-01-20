<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id', 'address', 'pincode', 'dob', 'date_of_joining', 'position_id'
    ];
}
