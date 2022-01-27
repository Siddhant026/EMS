<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    protected $fillable = [
        'user_id', 'address', 'pincode', 'dob', 'date_of_joining', 'position_id'
    ];

    public function position()
    {
        return $this->hasOne('App\Position', 'position_id');
    }

    public function create_function($user_id, $address, $pincode, $dob, $date_of_joining, $position_id, $role)
    {
        try {
            Employee::create([
                'user_id' => $user_id,
                'address' => $address,
                'pincode' => $pincode,
                'dob' => $dob,
                'date_of_joining' => $date_of_joining,
                'position_id' => $position_id,
            ]);
            User::where('id', '=', $user_id)->update(array('role' => $role));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function show_emp($where, $date_of_joining)
    {
        return Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->join('positions', 'employees.position_id', '=', 'positions.id')
            ->join('departments', 'positions.dept_id', '=', 'departments.id')
            ->select('employees.id as eid', 'users.name as uname', 'employees.dob as dob', 'employees.address as address', 'employees.pincode as pincode', 'users.email as email', 'employees.date_of_joining as date_of_joining', 'positions.name as pname', 'departments.name as dname', 'users.role as role', 'departments.id as dept_id', 'positions.id as pid')
            ->where($where)
            ->whereDate('date_of_joining', '>', $date_of_joining)
            ->get();
    }

    public function update_emp($id, $address, $pincode, $dob, $date_of_joining, $position_id, $role, $user_id)
    {
        try {
            Employee::where('id', '=', $id)->update(array('address' => $address, 'pincode' => $pincode, 'dob' => $dob, 'date_of_joining' => $date_of_joining, 'position_id' => $position_id));
            
            User::where('id', '=', $user_id)->update(array('role' => $role));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    // public function user() {
    //     // return $this->hasOne('App\User', 'user_id');
    //     return $this->hasOne(User::class);
    // }
}
