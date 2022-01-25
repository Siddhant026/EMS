<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Middleware\CheckRole;
use App\Jobs\HighPriority;
use App\Jobs\LowPriority;
use App\Jobs\MediumPriority;
use App\Mail\SendEmailMailable;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/home', 'WelcomeController@home');

Auth::routes();

Route::get('/employee/home', 'HomeController@employee')->name('employee.home');

Route::middleware(['admin', 'auth'])->group(function () {
    Route::get('/admin/home', 'HomeController@admin')->name('admin.home');
    Route::resource('/admin/user_mgnt', 'Admin\UserManagementController');
    Route::get('/user_filter', 'Admin\UserManagementController@filter');
    Route::resource('/admin/sys_mgnt/dept', 'Admin\DepartmentController');
    Route::resource('/admin/sys_mgnt/position', 'Admin\PositionController');
    Route::get('/position_filter', 'Admin\PositionController@filter'); 
    Route::resource('/admin/emp_mgnt/employee', 'Admin\EmployeeController');
    Route::get('/employee_filter', 'Admin\EmployeeController@filter');
});

Route::get('/sendEmail', function() {
    //HighPriority::dispatch();
    dispatch((new HighPriority)->onQueue('high'));
    dispatch((new MediumPriority)->onQueue('medium'));
    dispatch((new LowPriority)->onQueue('low'));
    return 'Email Sent';
});