<?php

namespace App\Http\Controllers\Admin;

use App\department;
use App\Http\Controllers\Controller;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$positions = Position::all();
        $departments = department::all();
        return view('admin.system_mgnt.position.show', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = department::all();
        return view('admin.system_mgnt.position.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //error_log($request->all()['dept_id']);
        $this->validator($request->all())->validate();
        $position = new Position();
        $position->create_position($request->all()['name'], $request->all()['dept_id']);
        return redirect('/admin/sys_mgnt/position');
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
        $departments = department::all();
        $position = Position::find($id);
        return view('admin.system_mgnt.position.edit', compact('departments', 'position'));
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
        $this->validator($request->all())->validate();
        $position = new Position();
        $position->update_position($id, $request->all()['name'], $request->all()['dept_id']);
        return redirect('/admin/sys_mgnt/position');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Position::destroy($id);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:positions',
            'dept_id' => 'required|max:10|exists:departments,id'
            // 'email' => 'required|email|max:255|unique:users', //exists:emails
            //'password' => 'required|min:6|confirmed',
        ]);
    }

    public function filter(Request $request)
    {
        if ($request->ajax()) {
            $name = $request->get('name');
            $dept_id = $request->get('dept_id');
            if (empty($dept_id)) {
                $where = [['name', 'like', '%' . $name . '%']];
            } else {
                $where = [['name', 'like', '%' . $name . '%'], ['dept_id', '=', $dept_id]];
            }

            $position = new Position();
            $positions = $position->get_position($where);

            $departments = department::all();
            $data = array(
                'positions' => $positions,
                'departments' => $departments
            );
            echo json_encode($data);
        }
    }
}
