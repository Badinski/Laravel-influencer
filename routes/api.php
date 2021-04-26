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

// Common routes

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::post('logout', 'AuthController@logout');

Route::group([
    'middleware' => 'auth:api'
], function(){
Route::get('user', 'AuthController@user');
Route::put('users/info', 'AuthController@updateInfo');
Route::put('users/password', 'AuthController@updatePassword');
});

/*Middleware provide a convenient mechanism for inspecting and filtering HTTP requests entering your application. 
For example, Laravel includes a middleware that verifies the user of your application 
is authenticated. If the user is not authenticated, the middleware will redirect the 
user to your application's login screen. However, if the user is authenticated, the 
middleware will allow the request to proceed further into the application.*/

// Admin routes

Route::group([
    'middleware' => ['auth:api', 'scope:admin'],
    'prefix' => 'admin',
    'namespace' => 'Admin'
], function () {
    Route::get('chart', 'DashboardController@chart');  
    Route::post('upload', 'ImageController@upload');
    Route::get('export', 'OrderController@export');

    Route::apiResource('users', 'UserController');
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('products', 'ProductController');
    Route::apiResource('orders', 'OrderController')->only('index', 'show');
    Route::apiResource('permissions', 'PermissionController')->only('index');
});

// Influencer routes

Route::group([
    'prefix' => 'influencer',
    'namespace' => 'Influencer'
], function () {
    Route::get('products', 'ProductController@index');

    Route::group([
        'middleware' => ['auth:api', 'scope:influencer'],
    ], function () {

    });
});