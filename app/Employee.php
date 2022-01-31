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
        Employee::create([
            'user_id' => $user_id,
            'address' => $address,
            'pincode' => $pincode,
            'dob' => $dob,
            'date_of_joining' => $date_of_joining,
            'position_id' => $position_id,
        ]);
    }

    public function show_emp($eid = '', $uname = '', $pincode = '', $dept_id = '',  $date_of_joining = '', $manager_id = '', $role = '')
    {
        $where = [['users.name', 'like', '%' . $uname . '%'], ['pincode', 'like', '%' . $pincode . '%']];
        if (!empty($eid)) {
            array_push($where, ['employees.id', '=', $eid]);
        }
        if (!empty($dept_id)) {
            array_push($where, ['dept_id', '=', $dept_id]);
        }
        if (!empty($manager_id)) {
            array_push($where, ['employees.manager_id', '=', $manager_id]);
        }
        if (!empty($role)) {
            array_push($where, ['role', '=', $role]);
        }
        return Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->join('positions', 'employees.position_id', '=', 'positions.id')
            ->join('departments', 'positions.dept_id', '=', 'departments.id')
            ->select('employees.id as eid', 'users.name as uname', 'employees.dob as dob', 'employees.address as address', 'employees.pincode as pincode', 'users.email as email', 'employees.date_of_joining as date_of_joining', 'positions.name as pname', 'departments.name as dname', 'users.role as role', 'departments.id as dept_id', 'positions.id as pid', 'employees.manager_id as mid')
            ->where($where)
            ->whereDate('date_of_joining', '>', $date_of_joining)
            ->get();
    }

    public function update_emp($id, $address, $pincode, $dob, $date_of_joining, $position_id, $role, $user_id)
    {
        Employee::where('id', '=', $id)->update(array('address' => $address, 'pincode' => $pincode, 'dob' => $dob, 'date_of_joining' => $date_of_joining, 'position_id' => $position_id));
    }

    public function assign_manager($eid, $mid) {
        Employee::where('id', '=', $eid)->update(array('manager_id' => $mid));
    }

    public function remove_manager($eid) {
        Employee::where('id', '=', $eid)->update(array('manager_id' => null));
    }

    // public function user() {
    //     // return $this->hasOne('App\User', 'user_id');
    //     return $this->hasOne(User::class);
    // }
}
