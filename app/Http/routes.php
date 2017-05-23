<?php
Route::get('/', [
	'as'=>'home',
	'uses'=>'Site\HomeController@index'
]);

Route::get('/login', [
	'as'=>'login-page',
	'uses'=>'Site\AuthController@loginPage'
]);
	Route::post('/login',[
		'as'=>'login',
		'uses'=>'Site\AuthController@login'
	]);
	Route::get('/logout',[
		'as'=>'logout',
		'uses'=>'Site\AuthController@logout'
	]);

Route::get('/registration', [
	'as'=>'registration-page',
	'uses'=>'Site\AuthController@registrationPage'
]);
	Route::post('/registration', [
	'as'=>'registration',
	'uses'=>'Site\AuthController@addUser'
	]);
	Route::get('/registration_confirm/{code}',[
		'as'=>'registration-confirm',
		'uses'=>'Site\AuthController@registrationConfirmPage'
	]);
	Route::get('/registration_failed', function(){
		return view('registration_failed');
	});
	Route::get('/password_reset',[
		'as'=>'password-reset-page',
		'uses'=>'Site\AuthController@passwordResetPage'
	]);


