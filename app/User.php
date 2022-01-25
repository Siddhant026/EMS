<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const ADMIN_ROLE = 0;
    const EMPLOYEE_ROLE = 1;
    const MANAGER_ROLE = 2;

    public function user() {
        // return $this->hasOne('App\User', 'user_id');
        return $this->hasOne(Employee::class);
    }
}
