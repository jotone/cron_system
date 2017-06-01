<?php
Route::get('/', [
	'as'=>'home',
	'uses'=>'Site\HomeController@index'
]);
//Логинизация
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
//Регистрация
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
	//Смена почты
	Route::patch('/email_change',[
		'as'=>'email-change',
		'uses'=>'Site\AuthController@emailChange'
	]);
		Route::get('/email_change/{code}',[
			'as'=>'email-change-request',
			'uses'=>'Site\AuthController@emailChangeRequest'
		]);
	//Смена пароля
	Route::patch('/password_change',[
		'as'=>'password-change',
		'uses'=>'Site\AuthController@passwordChange'
	]);
		Route::get('/password_change/{code}',[
			'as'=>'password-change-request',
			'uses'=>'Site\AuthController@passwordChangeRequest'
		]);
	//Забыли пароль
	Route::get('/password_reset',[
		'as'=>'password-reset',
		'uses'=>'Site\AuthController@passwordResetPage'
	]);
		Route::post('/password_reset',[
			'as'=>'password-reset-request',
			'uses'=>'Site\AuthController@passwordResetRequest'
		]);
//Личный кабинет
Route::get('/user_panel',[
	'as'=>'user-panel',
	'uses'=>'Site\UserController@index'
]);
	Route::patch('/user_modify', [
		'uses'=>'Site\UserController@modifyUser'
	]);
//О нас
Route::get('/about_us',[
	'as'=>'about-us',
	'uses'=>'Site\HomeController@aboutUs'
]);
//Контакная информация
Route::get('/contacts',[
	'as'=>'contacts',
	'uses'=>'Site\HomeController@contacts'
]);
//Бренды
Route::get('/brand',[
	'as'=>'brand',
	'uses'=>'Site\HomeController@brand'
]);
//Каталог
Route::get('/catalog',[
	'as'=>'catalog',
	'uses'=>'Site\HomeController@catalog'
]);
//Оборудование
Route::get('/equipment',[
	'as'=>'equipment',
	'uses'=>'Site\HomeController@equipment'
]);
//Новости
Route::get('/news/',[
	'as'=>'news',
	'uses'=>'Site\NewsController@news'
]);
Route::get('/news/page/{page}',[
	'uses'=>'Site\NewsController@news'
]);
	Route::get('/news/{slug}',[
		'as'=>'news-inner',
		'uses'=>'Site\NewsController@newsInner'
	]);
//Уточнить цену
Route::get('/request',[
	'as'=>'request',
	'uses'=>'Site\HomeController@request'
]);
//Услуги
Route::get('/services',[
	'as'=>'services',
	'uses'=>'Site\HomeController@services'
]);
//Вакансии
Route::get('/vacancies',[
	'as'=>'vacancies',
	'uses'=>'Site\HomeController@vacancies'
]);
	Route::get('/vacancies/{slug}',[
		'as'=>'vacancies-inner',
		'uses'=>'Site\HomeController@vacanciesInner'
	]);
//Корзина
Route::get('/shopping_cart',[
	'as'=>'shopping_cart',
	'uses'=>'Site\ShoppingCartController@index'
]);
	Route::get('/thanks',[
		'as'=>'thanks',
		'uses'=>'Site\HomeController@thanks'
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
	//Меню в подвале
	Route::get('/admin/footer_menu',[
		'as'=>'admin-footer-menu',
		'uses'=>'Admin\FooterMenuController@index'
	]);
		Route::get('/admin/footer_menu/add',[
			'as'=>'admin-footer-menu-add',
			'uses'=>'Admin\FooterMenuController@addPage'
		]);
		Route::get('/admin/footer_menu/edit/{id}',[
			'as'=>'admin-footer-menu-edit',
			'uses'=>'Admin\FooterMenuController@editPage'
		]);
		Route::post('/admin/footer_menu/add',[
			'uses'=>'Admin\FooterMenuController@addItem'
		]);
		Route::delete('/admin/footer_menu/drop',[
			'uses'=>'Admin\FooterMenuController@dropItem'
		]);
	//Галлерея
	Route::get('/admin/gallery',[
		'as'=>'admin-gallery',
		'uses'=>'Admin\GalleryController@index'
	]);
		Route::post('/admin/gallery/add',[
			'uses'=>'Admin\GalleryController@addImage'
		]);
		Route::delete('/admin/gallery/drop',[
			'uses'=>'Admin\GalleryController@dropImage'
		]);
	//Новости
	Route::get('/admin/news',[
		'as'=>'admin-news',
		'uses'=>'Admin\NewsController@index'
	]);
		Route::get('/admin/news/add',[
			'as'=>'admin-news-add',
			'uses'=>'Admin\NewsController@addPage'
		]);
		Route::get('/admin/news/edit/{id}',[
			'as'=>'admin-news-edit',
			'uses'=>'Admin\NewsController@editPage'
		]);
		Route::post('/admin/news/add',[
			'uses'=>'Admin\NewsController@addItem'
		]);
		Route::delete('/admin/news/drop',[
			'uses'=>'Admin\NewsController@dropItem'
		]);
	//Брэнды
	Route::get('/admin/brands',[
		'as'=>'admin-brands',
		'uses'=>'Admin\BrandController@index'
	]);
		Route::get('/admin/brands/add',[
			'as'=>'admin-brands-add',
			'uses'=>'Admin\BrandController@addPage'
		]);
		Route::get('/admin/brands/edit/{id}',[
			'as'=>'admin-brands-edit',
			'uses'=>'Admin\BrandController@editPage'
		]);
		Route::post('/admin/brands/add',[
			'uses'=>'Admin\BrandController@addItem'
		]);
		Route::delete('/admin/brands/drop',[
			'uses'=>'Admin\BrandController@dropItem'
		]);

	//Similar queries
	Route::get('/admin/get_all_images',[
		'uses'=>'Supply\Functions@getAllImagesByRequest'
	]);
	Route::patch('/admin/change_enabled',[
		'uses'=>'Admin\SimilarQueriesController@changeEnabled'
	]);
	Route::patch('/admin/change_postions',[
		'uses'=>'Admin\SimilarQueriesController@changePositions'
	]);
});