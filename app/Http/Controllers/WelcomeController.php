<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class WelcomeController extends Controller
{
    //

    public function index()
    {
        return view('auth.login');
    }

    public function home()
    {
        $role = Auth::user()->role;
        //error_log(User::ADMIN_ROLE);
        if ($role == User::ADMIN_ROLE) {
            return redirect('/admin/home');
        } else {
            return redirect('/employee/home');
        }
    }

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
}
