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
Route::post('register', 'API\UserController@register');
Route::post('login', 'API\UserController@login');

Route::post('/password/email', 'API\ForgotPasswordController@sendResetLinkEmail');
Route::post('/password/reset', 'API\ResetPasswordController@reset');


Route::middleware('auth:api')->group(function () {
		
		Route::post('lead', 'API\LeadController@details');
		Route::post('contacts', 'API\LeadController@clist');
		Route::post('logout', 'API\UserController@logout');
		Route::post('profile', 'API\ProfileController@profile');
		Route::post('profile/update', 'API\ProfileController@update');
});
