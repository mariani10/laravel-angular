<?php

use Illuminate\Http\Request;

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

Route::post('api-login', 'ApiLoginController@api_login');

Route::group(['prefix' => 'v1', 'middleware' => ['acl-api']], function()
{
	Route::get('test', function()
	{
		return 'aaa';#$request->user();
	});
});