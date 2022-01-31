<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date_of_joiningtime = strtotime('');
        $date_of_joining = date('Y-m-d', $date_of_joiningtime);

        $employee = new Employee();
        $managers = $employee->show_emp('', '', '', '', $date_of_joining, '', User::MANAGER_ROLE);

        $employees = $employee->show_emp();

        return view('admin.emp_mgnt.manager.index', compact('managers', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.emp_mgnt.manager.add_emp');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function add_emp($eid, $mid)
    {
        // $date_of_joiningtime = strtotime('');
        // $date_of_joining = date('Y-m-d', $date_of_joiningtime);

        $employee = new Employee();
        $employee->assign_manager($eid, $mid);

        // $managers = $employee->show_emp('', '', '', '', $date_of_joining, '', User::MANAGER_ROLE);

        // return view('admin.emp_mgnt.manager.index', compact('managers', 'mid'));

        //return redirect('/admin/emp_mgnt/manager');
    }

    public function remove_emp($eid)
    {
        $employee = new Employee();
        $employee->remove_manager($eid);
    }
}
