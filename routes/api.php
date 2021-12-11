<?php

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

Route::post('employee_login', 'Api\Employees_V2_Controller@login')->name('login.api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:api'])->group(function () {
    Route::post('add_employee', 'Api\EmployeesController@store');
    Route::get('list_employee','Api\EmployeesController@index');
    Route::get('deactivate_employee/{id}','Api\EmployeesController@deactivate');
    Route::post('update_profile','Api\Employees_V2_Controller@update');
});
