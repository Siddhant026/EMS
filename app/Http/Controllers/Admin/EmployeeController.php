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
        return view('admin.emp_mgnt.show');
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        //error_log('data validated');
        $user = json_decode($request->all()['email']);
        //error_log($user->id);
        $dobtime = strtotime($request->all()['dob']);
        $dob = date('Y-m-d',$dobtime);
        $date_of_joiningtime = strtotime($request->all()['date_of_joining']);
        $date_of_joining = date('Y-m-d',$date_of_joiningtime);
        //error_log($newformat);
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
            'email' => 'required|max:255',
            'address' => 'required|max:255',
            'pincode' => 'required|numeric',
            'dob' => 'required|max:255',
            'date_of_joining' => 'required|max:255',
            'role' => 'required|max:255',
            'position_id' => 'required|max:255|exists:positions,id',
            // 'email' => 'required|email|max:255|unique:users', //exists:emails
            //'password' => 'required|min:6|confirmed',
        ]);
    }
}
