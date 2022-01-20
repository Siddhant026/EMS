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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/home', 'WelcomeController@home');

Auth::routes();

Route::get('/employee/home', 'HomeController@employee')->name('employee.home');

Route::middleware('admin')->group(function () {
    Route::get('/admin/home', 'HomeController@admin')->name('admin.home');
    Route::resource('/admin/user_mgnt', 'Admin\UserManagementController');
    Route::get('/user_filter', 'Admin\UserManagementController@filter');
    Route::resource('/admin/sys_mgnt/dept', 'Admin\DepartmentController');
    Route::resource('/admin/sys_mgnt/position', 'Admin\PositionController');
    Route::get('/position_filter', 'Admin\PositionController@filter');
    Route::resource('/admin/emp_mgnt/employee', 'Admin\EmployeeController');
});
