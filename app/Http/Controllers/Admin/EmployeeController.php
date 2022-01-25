<?php

namespace App\Http\Controllers\Admin;

use App\department;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Position;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = department::all();
        return view('admin.emp_mgnt.show', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $departments = department::all();
        $positions = Position::all();
        return view('admin.emp_mgnt.create', compact('users', 'departments', 'positions'));
        //['users' => $]
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->validator($request->all())->validate();
        //error_log('data validated');
        $user = json_decode($request->all()['email']);
        error_log($user->id);
        $dobtime = strtotime($request->all()['dob']);
        $dob = date('Y-m-d', $dobtime);
        $date_of_joiningtime = strtotime($request->all()['date_of_joining']);
        $date_of_joining = date('Y-m-d', $date_of_joiningtime);
        foreach ($request->all() as $key => $value) {
            echo $key . " " . $value . "<br>";
        }
        //error_log($newformat);
        $this->validator(array("_token" => $request->all()['_token'], "email" => $user->id, "address" => $request->all()['address'], "pincode" => $request->all()['pincode'], "dob" => $dob, "date_of_joining" => $date_of_joining, "role" => $request->all()['role'], "position_id" => $request->all()['position_id']))->validate();
        //error_log('min max data validated');
        Employee::create([
            'user_id' => $user->id,
            'address' => $request->all()['address'],
            'pincode' => $request->all()['pincode'],
            'dob' => $dob,
            'date_of_joining' => $date_of_joining,
            'position_id' => $request->all()['position_id'],
        ]);
        User::where('id', '=', $user->id)->update(array('role' => $request->all()['role']));
        return redirect('/admin/emp_mgnt/employee');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|max:255|exists:users,id',
            'address' => 'required|max:255',
            'pincode' => 'required|numeric',
            'dob' => 'required|date',
            'date_of_joining' => 'required|date|after:dob',
            'role' => 'required|max:' . User::MANAGER_ROLE . '|min:' . User::EMPLOYEE_ROLE,
            'position_id' => 'required|max:255|exists:positions,id',
            // 'email' => 'required|email|max:255|unique:users', //exists:emails
            //'password' => 'required|min:6|confirmed',
        ]);
    }

    public function filter(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $name = $request->get('name');
            $dept_id = $request->get('dept_id');
            $pincode = $request->get('pincode');
            //print_r(Employee::find(2));
            $date_of_joining = $request->get('date_of_joining');
            $date_of_joiningtime = strtotime($date_of_joining);
            $date_of_joining = date('Y-m-d', $date_of_joiningtime);
            if (empty($dept_id)) {
                $where = [['users.name', 'like', '%' . $name . '%'], ['pincode', 'like', '%' . $pincode . '%']];
            } else {
                $where = [['users.name', 'like', '%' . $name . '%'], ['dept_id', '=', $dept_id], ['pincode', 'like', '%' . $pincode . '%']];
            }
            // $employees = User::find(5);
            // dd($employees->user);
            // foreach ($employees as $employee) {
            //     print_r($employee->user);
            // }
            //dd($employees->user->name);
            // $positions = Position::find(6);
            // $positions = Position::select('positions.name as pname', 'positions.id as pid', 'departments.id as did', 'departments.name as dname')->join('departments', 'positions.dept_id', '=', 'departments.id')->get();
            $employees = Employee::join('users', 'employees.user_id', '=', 'users.id')
                ->join('positions', 'employees.position_id', '=', 'positions.id')
                ->join('departments', 'positions.dept_id', '=', 'departments.id')
                ->select('users.name as uname', 'employees.dob as dob', 'employees.address as address', 'employees.pincode as pincode', 'users.email as email', 'employees.date_of_joining as date_of_joining', 'positions.name as pname', 'departments.name as dname', 'users.role as role', 'departments.id as dept_id')
                ->where($where)
                ->whereDate('date_of_joining', '>', $date_of_joining)
                ->get();
            dd($employees);
            //dd($positions->department);
            // if (empty($dept_id)) {
            //     $positions = Position::where([['name', 'like', '%' . $name . '%']])
            //         ->get();
            // } else {
            //     $positions = Position::where([['name', 'like', '%' . $name . '%'], ['dept_id', '=', $dept_id]])
            //         ->get();
            // }
            // $departments = department::all();
            // $data = array(
            //     'positions' => $positions,
            //     //'departments' => $departments
            // );
            // echo json_encode($data);
        }
    }
}
