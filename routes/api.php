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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->namespace("API")->group(function () {

    Route::apiResource('user', 'UserController');

    
    Route::namespace("AdminBoard")->group(function () {
        Route::apiResource('assert_types', 'AssertTypeController');
        
        Route::apiResource('element_category', 'ElementCategoryController');
        
        Route::get('remarks/search', 'RemarksController@search');
        Route::apiResource('remarks', 'RemarksController');
    });

    Route::namespace("Management")->group(function () {

        Route::get('staff/login', 'StaffUserController@loginUser');
        Route::apiResource('staff', 'StaffUserController');

        Route::apiResource('roles', 'RoleController');
        Route::apiResource('permissions', 'PermissionController');
    });
});
