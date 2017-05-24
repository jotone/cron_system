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
	Route::get('/password_reset',[
		'as'=>'password-reset-page',
		'uses'=>'Site\AuthController@passwordResetPage'
	]);

Route::get('/user_panel', [
	'as'=>'user-panel',
	'uses'=>'Site\UserController@index'
]);
	Route::patch('/user_modify', [
		'uses'=>'Site\UserController@modifyUser'
	]);

//Authorisation
Route::get('/admin/login', [
	'as'	=> 'admin-login',
	'uses'	=> 'Admin\AuthController@loginPage'
]);
Route::post('/admin/login', [
	'as'	=> 'login-as-admin',
	'uses'	=> 'Admin\AuthController@login'
]);

Route::group(['middleware' => 'admin'], function(){
	//Админ Главная
	Route::get('/admin', [
		'as'	=> 'admin-index',
		'uses'	=> 'Admin\HomeController@index'
	]);
	//Пользователи
	Route::get('/admin/users',[
		'as'=>'admin-users',
		'uses'=>'Admin\UserController@index'
	]);
	//Роли пользователей
    Route::get('/admin/users/roles',[
        'as'=>'admin-users-roles',
        'uses'=>'Admin\UserRolesController@index'
    ]);
});