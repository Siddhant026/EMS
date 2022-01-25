<?php

namespace App\Http\Controllers\Admin;

use App\department;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Position;
use App\User;
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
        $user = json_decode($request->all()['email']);
        $dobtime = strtotime($request->all()['dob']);
        $dob = date('Y-m-d', $dobtime);
        $date_of_joiningtime = strtotime($request->all()['date_of_joining']);
        $date_of_joining = date('Y-m-d', $date_of_joiningtime);
        $department = json_decode($request->all()['department']);

        $this->validator(array("_token" => $request->all()['_token'], "email" => $user->id, "address" => $request->all()['address'], "pincode" => $request->all()['pincode'], "dob" => $dob, "date_of_joining" => $date_of_joining, "role" => $request->all()['role'], "department" => $department->id, "position" => $request->all()['position'],))->validate();

        $employee = new Employee();
        $employee->create_function($user->id, $request->all()['address'], $request->all()['pincode'], $dob, $date_of_joining, $request->all()['position'], $request->all()['role']);

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
        $date_of_joiningtime = strtotime('');
        $date_of_joining = date('Y-m-d', $date_of_joiningtime);

        $where = [['employees.id', '=', $id]];

        $employee = new Employee();
        $employee = $employee->show_emp($where, $date_of_joining);
        //$employee = Employee::find($id);
        $users = User::all();
        $departments = department::all();
        $positions = Position::all();
        return view('admin.emp_mgnt.edit', compact('employee', 'users', 'departments', 'positions'));
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
            'email' => 'required|max:255|exists:users,id|unique:employees,user_id',
            'address' => 'required|max:255',
            'pincode' => 'required|numeric',
            'dob' => 'required|date',
            'date_of_joining' => 'required|date|after:dob',
            'role' => 'required|max:' . User::MANAGER_ROLE . '|min:' . User::EMPLOYEE_ROLE,
            'department' => 'required|max:255|exists:departments,id',
            'position' => 'required|max:255|exists:positions,id',
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

            $employee = new Employee();
            $employees = $employee->show_emp($where, $date_of_joining);

            $data = array(
                'employees' => $employees
            );
            echo json_encode($data);
        }
    }
}
