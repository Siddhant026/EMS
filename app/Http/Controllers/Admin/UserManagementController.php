<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //error_log('inside index');
        //$users = User::all();
        return view('admin.user_mgnt.show');
        //return back()->with(['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('auth.register');
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
        // if ($request->ajax()) {
        //     $name = $request->get('name');
        //     $email = $request->get('email');
        //     $role = $request->get('role');
        //     error_log($name);
        // }
        error_log($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //error_log("edit ".$id);
        $user = User::where('id', '=', $id)
            ->get();
        //error_log($user);
        return view('admin.user_mgnt.edit', compact('user'));
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
        if(strcasecmp(Auth::user()->emial, $request->all()['email'])) {
            error_log('both email same');
            $this->validatorSameEmail($request->all())->validate();
        } else {
            error_log('both email different');
            $this->validator($request->all())->validate();
        }
        User::where('id', $id)
                ->update(array('name' => $request->all()['name'], 'email' => $request->all()['email'], 'password' => bcrypt($request->all()['password'])));
        
        return redirect('/admin/user_mgnt');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        error_log("destroy");
        User::destroy($id);
    }

    public function filter(Request $request)
    {
        //error_log('inside filter');
        // $users = "";
        // return (['users'=>$users]);
        if ($request->ajax()) {
            $name = $request->get('name');
            $email = $request->get('email');
            $role = $request->get('role');
            if (strcasecmp($role, 'admin') == 0) {
                $role = 0;
            }
            //error_log('inside filter');
            $users = User::where([['name', 'like', '%' . $name . '%'], ['email', 'like', '%' . $email . '%'], ['role', 'like', '%' . $role . '%']])
                ->get();
            $data = array(
                'users' => $users
            );
            echo json_encode($data);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    protected function validatorSameEmail(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            //'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }
}
