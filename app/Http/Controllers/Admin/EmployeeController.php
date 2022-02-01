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
        return view('admin.emp_mgnt.employee.show', compact('departments'));
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
        return view('admin.emp_mgnt.employee.create', compact('users', 'departments', 'positions'));
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
        $user = new User();

        DB::beginTransaction();

        try {
            $employee->create_function($user->id, $request->all()['address'], $request->all()['pincode'], $dob, $date_of_joining, $request->all()['position'], $request->all()['role']);
            $user->update_user_role($user->id, $request->all()['role']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
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
        $name = '';
        $pincode = '';
        $dept_id = '';
        $manager_id = '';
        $role = '';

        $employee = new Employee();
        $employee = $employee->show_emp($id, $name, $pincode, $dept_id, $date_of_joining, $manager_id, $role);
        //$employee = Employee::find($id);
        $users = User::all();
        $departments = department::all();
        $positions = Position::all();
        return view('admin.emp_mgnt.employee.edit', compact('employee', 'users', 'departments', 'positions'));
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
        $user = json_decode($request->all()['email']);
        $dobtime = strtotime($request->all()['dob']);
        $dob = date('Y-m-d', $dobtime);
        $date_of_joiningtime = strtotime($request->all()['date_of_joining']);
        $date_of_joining = date('Y-m-d', $date_of_joiningtime);
        $department = json_decode($request->all()['department']);

        $this->validator_without_email(array("_token" => $request->all()['_token'], "address" => $request->all()['address'], "pincode" => $request->all()['pincode'], "dob" => $dob, "date_of_joining" => $date_of_joining, "role" => $request->all()['role'], "department" => $department->id, "position" => $request->all()['position'],))->validate();

        $employee = new Employee();
        $user = new User();

        DB::beginTransaction();

        try {
            $employee->update_emp($id, $request->all()['address'], $request->all()['pincode'], $dob, $date_of_joining, $request->all()['position'], $request->all()['role'], $user->id);
            $user->update_user_role($user->id, $request->all()['role']);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }



        return redirect('/admin/emp_mgnt/employee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Employee::find($id)->user_id;
        User::destroy($user_id);
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

    protected function validator_without_email(array $data)
    {
        return Validator::make($data, [
            //'email' => 'required|max:255|exists:users,id|unique:employees,user_id',
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
        $eid = '';
        $name = $request->get('name');
        $dept_id = $request->get('dept_id');
        $pincode = $request->get('pincode');
        //print_r(Employee::find(2));
        $date_of_joining = $request->get('date_of_joining');
        $date_of_joiningtime = strtotime($date_of_joining);
        $date_of_joining = date('Y-m-d', $date_of_joiningtime);
        //$manager_id = $request->get('manager_id');
        $role = '';

        $employee = new Employee();
        $employees = $employee->show_emp($eid, $name, $pincode, $dept_id, $date_of_joining, '', $role);

        $data = array(
            'employees' => $employees
        );
        if ($request->ajax()) {
            echo json_encode($data);
        } else {
            return json_encode($data);
        }
        // return json_encode($data);
    }

    function filter_api(Request $request)
    {
        $eid = '';
        $name = $request->get('name');
        $dept_id = $request->get('dept_id');
        $pincode = $request->get('pincode');
        $date_of_joining = $request->get('date_of_joining');
        $date_of_joiningtime = strtotime($date_of_joining);
        $date_of_joining = date('Y-m-d', $date_of_joiningtime);
        $role = '';

        $page = $request->get('page');

        if (!isset($page)) {
            $page = 1;
        } 

        $limit = 1;

        $skip = ($page - 1) * $limit;

        $employee = new Employee();
        $employees = $employee->show_emp_pagination($eid, $name, $pincode, $dept_id, $date_of_joining, '', $role, $limit, $skip);

        $data = array(
            'employees' => $employees
        );
        return json_encode($data);
    }
}
