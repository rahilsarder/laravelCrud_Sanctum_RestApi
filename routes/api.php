<?php

use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\DutyTimesController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Login & Register Routes
Route::post('user/register_user', 'AuthController@register');
Route::post('user/login', 'AuthController@login');


Route::get('user/get_user_details', 'ThirdPartyAPIs@index');
Route::post('user/payment', 'ThirdPartyAPIs@create');


Route::get('user/invoice', 'AttendancesController@generateInvoice');

Route::get('user/attend/{id}', 'SalaryCalculationsController@show');
//Authorized Routes

Route::group(['middleware' => ['auth:sanctum']], function () {

    //Products Routes
    Route::get('/products', 'ProductController@index');
    Route::get('/products/paginate/{paginate}', 'ProductController@paginate');
    Route::post('/add_product', 'ProductController@store');
    Route::get('/product/{id}', 'ProductController@show');
    Route::put('/product/update/{id}', 'ProductController@update');
    Route::delete('/product/{id}', 'ProductController@destroy');
    Route::get('product/search/{name?}', 'ProductController@search');
    Route::post('product/{product_id}/add_to_cart', 'ProductController@addToCart');
    Route::put('product/{product_id}/updateCart', 'ProductController@updateCart');

    //Carts Routes

    Route::get('show_cart', 'ProductController@getIndividualCart');
    Route::get('show_cart_all', 'ProductController@getAllCart');

    //Auth Routes

    Route::post('user/logout', 'AuthController@logout');
    Route::get('user/list', 'AuthController@index');
    Route::get('user/check', 'AuthController@User');

    //Employees Routes

    Route::get('employees', 'EmployeesController@index');
    Route::get('employees/{id}', 'EmployeesController@show');
    Route::get('employees/all', 'EmployeesController@showRelations');
    Route::post('employee/create', 'EmployeesController@create');
    Route::delete('employee/{id}/delete', 'EmployeesController@destroy');
    Route::get('employee/search/{name?}', 'EmployeesController@search');

    //Departments Routes

    Route::get('departments', 'DepartmentsController@index');
    Route::get('departments/show/all', 'DepartmentsController@showRelations');
    Route::get('department/{id}', 'DepartmentsController@show');
    Route::post('department/create', "DepartmentsController@create");
    Route::post('department/{id}/delete', 'DepartmentsController@destroy');

    //DutyTimes Routes

    Route::get('duty_times', 'DutyTimesController@index');
    Route::get('duty_times/{id}', 'DutyTimesController@show');
    Route::get('duty_times/show/all', 'DutyTimesController@showRelations');
    Route::delete('duty_times/{id}/delete', 'DutyTimesController@destroy');
    Route::post('duty_time/create', 'DutyTimesController@create');
    Route::put('duty_time/{id}/update', 'DutyTimesController@update'); // doesn't work with form-data body type but works with x-www-form-urlendcoded

    //Attendance Routes

    Route::get('employee/attendance', 'AttendancesController@index');
    Route::post('employee/attendance/create', 'AttendancesController@store');

    //Employee DashBoard
});
