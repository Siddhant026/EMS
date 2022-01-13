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

Auth::routes();

Route::get('/admin/home', 'HomeController@index')->name('admin.home');

Route::resource('/admin/userMgnt', 'UserManagementController');
