<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Route::get('/', function () {
//     return view('index');
// });

// Route::group([
//     'prefix' => 'api/v1',
//     'namespace' => 'Api'
// ], function () {

//     Route::post('/auth/register', [
//         'as' => 'auth.register',
//         'uses' => 'AuthController@register'
//     ]);

//     Route::post('/auth/login', [
//         'as' => 'auth.login',
//         'uses' => 'AuthController@login'
//     ]);
// });

Route::post('api/register', 'Api\AuthController@register');
Route::post('api/authenticate', 'Api\AuthController@authenticate');
Route::get('api/authenticate/user', 'Api\AuthController@getAuthenticatedUser');
Route::get('api/decode', 'Api\AuthController@decode');
Route::get('api/user', 'Api\AuthController@getUser');