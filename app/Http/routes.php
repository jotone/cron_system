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

Route::get('/about_us', function(){
	return view('about_us', ['allow_map'=>true]);
});

Route::get('/contacts', function(){
	return view('contacts', ['allow_map'=>true]);
});

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
		Route::get('/admin/users/edit/{id}',[
			'as'=>'admin-users-edit-page',
			'uses'=>'Admin\UserController@editPage'
		]);
		Route::post('/admin/users/edit',[
			'uses'=>'Admin\UserController@editItem'
		]);
		Route::delete('/admin/users/drop',[
			'uses'=>'Admin\UserController@dropItem'
		]);
	//Роли пользователей
	Route::get('/admin/users/roles',[
		'as'=>'admin-users-roles',
		'uses'=>'Admin\UserRolesController@index'
	]);
		Route::get('/admin/users/roles/add',[
			'as'=>'admin-users-roles-add-page',
			'uses'=>'Admin\UserRolesController@addPage'
		]);
		Route::get('/admin/users/roles/edit/{id}',[
			'as'=>'admin-users-roles-edit-page',
			'uses'=>'Admin\UserRolesController@editPage'
		]);
		Route::post('/admin/users/roles/add',[
			'uses'=>'Admin\UserRolesController@addItem'
		]);
		Route::delete('/admin/users/roles/drop',[
			'uses'=>'Admin\UserRolesController@dropItem'
		]);
	//Меню в Шапке
	Route::get('/admin/top_menu',[
		'as'=>'admin-top-menu',
		'uses'=>'Admin\TopMenuController@index'
	]);
		Route::get('/admin/top_menu/add',[
			'as'=>'admin-top-menu-add',
			'uses'=>'Admin\TopMenuController@addPage'
		]);
		Route::get('/admin/top_menu/edit/{id}',[
			'as'=>'admin-top-menu-edit',
			'uses'=>'Admin\TopMenuController@editPage'
		]);
		Route::post('/admin/top_menu/add',[
			'uses'=>'Admin\TopMenuController@addItem'
		]);
		Route::delete('/admin/top_menu/drop',[
			'uses'=>'Admin\TopMenuController@dropItem'
		]);


	//Similar queries
	Route::patch('/admin/change_enabled',[
		'uses'=>'Admin\SimilarQueriesController@changeEnabled'
	]);
	Route::patch('/admin/change_postions',[
		'uses'=>'Admin\SimilarQueriesController@changePositions'
	]);
});