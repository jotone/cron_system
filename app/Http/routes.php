<?php
Route::get('/', [
	'as'=>'home',
	'uses'=>'Site\HomeController@index'
]);
	Route::get('/get_more_products',[
		'uses'=>'Site\HomeController@getMoreProducts'
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
Route::get('/brand/{brand}/page/{page?}',[
	'uses'=>'Site\ProductController@brand'
]);
	Route::get('/brand/{brand}/{slug?}',[
		'as'=>'brand',
		'uses'=>'Site\ProductController@brand'
	]);
	Route::get('/brand/{brand}/{slug?}/page/{page?}',[
		'uses'=>'Site\ProductController@brand'
	]);
	Route::get('/brand', [
		'uses'=>'Site\ProductController@redirectToCatalog'
	]);
//Каталог
Route::get('/catalog',[
	'as'=>'catalog',
	'uses'=>'Site\ProductController@catalog'
]);
	Route::get('/catalog/page/{page?}',[
		'uses'=>'Site\ProductController@catalog'
	]);
//Специальные предложения
Route::get('/special_offers',[
	'as'=>'special_offers',
	'uses'=>'Site\ProductController@specialOffers'
]);
	Route::get('/special_offers/page/{page?}',[
		'uses'=>'Site\ProductController@specialOffers'
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
	'uses'=>'Site\ServicesController@services'
]);
//Вакансии
Route::get('/vacancies',[
	'as'=>'vacancies',
	'uses'=>'Site\VacanciesController@vacancies'
]);
Route::get('/vacancies/page/{page}',[
	'uses'=>'Site\VacanciesController@vacancies'
]);
	Route::get('/vacancies/{slug}',[
		'as'=>'vacancies-inner',
		'uses'=>'Site\VacanciesController@vacanciesInner'
	]);
	Route::post('/send_resume',[
		'as'=>'vacancies-send-resume',
		'uses'=>'Site\VacanciesController@sendResume'
	]);
//Корзина
Route::get('/shopping_cart',[
	'as'=>'shopping_cart',
	'uses'=>'Site\ShoppingCartController@index'
]);
	Route::post('/add_to_card',[
		'uses'=>'Site\ShoppingCartController@addItem'
	]);
	Route::delete('/drop_from_cart',[
		'uses'=>'Site\ShoppingCartController@dropItem'
	]);
	Route::get('/get_cart_items',[
		'uses'=>'Supply\Helpers@getShoppingCartByRequest'
	]);
	Route::post('/thanks',[
		'as'=>'shopping-card-checkout',
		'uses'=>'Site\ShoppingCartController@checkout'
	]);
	Route::put('/update_cart',[
		'uses'=>'Site\ShoppingCartController@updateCart'
	]);

Route::patch('/change_per_page',[
	'uses'=>'Supply\Helpers@changePerPage'
]);
Route::get('/filter_brand',[
	'uses'=>'Supply\Helpers@filterBrand'
]);
Route::patch('/change_filter',[
	'uses'=>'Supply\Helpers@changeFilter'
]);
Route::post('/ask_question',[
	'as'=>'ask-question',
	'uses'=>'Site\HomeController@askQuestion'
]);
Route::post('/order_phone_call',[
	'as'=>'order-phone-call',
	'uses'=>'Site\ServicesController@orderPhoneCall'
]);

//Authorisation
Route::get('/admin/login', [
	'as'=>'admin-login',
	'uses'=>'Admin\AuthController@loginPage'
]);
Route::post('/admin/login', [
	'as'=>'login-as-admin',
	'uses'=>'Admin\AuthController@login'
]);

Route::group(['middleware' => 'admin'], function(){
	//Админ Главная
	Route::get('/admin', [
		'as'=>'admin-index',
		'uses'=>'Admin\HomeController@index'
	]);
		Route::patch('/admin/orders/change_status',[
			'uses'=>'Admin\HomeController@changeStatus'
		]);
		Route::delete('/admin/orders/drop',[
			'uses'=>'Admin\HomeController@orderDrop'
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
	//Контактные данные
	Route::get('/admin/info',[
		'as'=>'admin-info',
		'uses'=>'Admin\ContactsController@index'
	]);
		Route::post('/admin/info',[
			'uses'=>'Admin\ContactsController@save'
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
	//Вакансии
	Route::get('/admin/vacancies',[
		'as'=>'admin-vacancies',
		'uses'=>'Admin\VacanciesController@index'
	]);
		Route::get('/admin/vacancies/add',[
			'as'=>'admin-vacancies-add',
			'uses'=>'Admin\VacanciesController@addPage'
		]);
		Route::get('/admin/vacancies/edit/{id}',[
			'as'=>'admin-vacancies-edit',
			'uses'=>'Admin\VacanciesController@editPage'
		]);
		Route::post('/admin/vacancies/add',[
			'uses'=>'Admin\VacanciesController@addItem'
		]);
		Route::delete('/admin/vacancies/drop',[
			'uses'=>'Admin\VacanciesController@dropItem'
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
	//Категории
	Route::get('/admin/categories',[
		'as'=>'admin-categories',
		'uses'=>'Admin\CategoryController@index'
	]);
		Route::get('/admin/categories/add',[
			'as'=>'admin-categories-add',
			'uses'=>'Admin\CategoryController@addPage'
		]);
		Route::get('/admin/categories/edit/{id}',[
			'as'=>'admin-categories-edit',
			'uses'=>'Admin\CategoryController@editPage'
		]);
		Route::post('/admin/categories/add',[
			'uses'=>'Admin\CategoryController@addItem'
		]);
		Route::delete('/admin/categories/drop',[
			'uses'=>'Admin\CategoryController@dropItem'
		]);
	//Способы доставки
	Route::get('/admin/delivery_type',[
		'as'=> 'admin-delivery',
		'uses'=> 'Admin\DeliveryTypeController@index'
	]);
		Route::get('/admin/delivery_type/add',[
			'as'=>'admin-delivery-add',
			'uses'=>'Admin\DeliveryTypeController@addPage'
		]);
		Route::get('/admin/delivery_type/edit/{id}',[
			'as'=>'admin-delivery-edit',
			'uses'=>'Admin\DeliveryTypeController@editPage'
		]);
		Route::post('/admin/delivery_type/add',[
			'uses'=>'Admin\DeliveryTypeController@addItem'
		]);
		Route::delete('/admin/delivery_type/drop',[
			'uses'=>'Admin\DeliveryTypeController@dropItem'
		]);
	//Товары
	Route::get('/admin/products',[
		'as'=>'admin-products',
		'uses'=>'Admin\ProductController@index'
	]);
		Route::get('/admin/products/add',[
			'as'=>'admin-products-add',
			'uses'=>'Admin\ProductController@addPage'
		]);
		Route::get('/admin/products/edit/{id}',[
			'as'=>'admin-products-edit',
			'uses'=>'Admin\ProductController@editPage'
		]);
		Route::post('/admin/products/add',[
			'uses'=>'Admin\ProductController@addItem'
		]);
		Route::delete('/admin/products/drop',[
			'uses'=>'Admin\ProductController@dropItem'
		]);
	//Страницы
	Route::get('/admin/pages',[
		'as'=>'admin-pages',
		'uses'=>'Admin\PagesController@index'
	]);
		Route::get('/admin/pages/add',[
			'as'=>'admin-pages-add',
			'uses'=>'Admin\PagesController@addPage'
		]);
		Route::get('/admin/pages/edit/{id}',[
			'as'=>'admin-pages-edit',
			'uses'=>'Admin\PagesController@editPage'
		]);
		Route::post('/admin/pages/add',[
			'uses'=>'Admin\PagesController@addItem'
		]);
		Route::delete('/admin/pages/drop',[
			'uses'=>'Admin\PagesController@dropItem'
		]);
		Route::get('/admin/get_template',[
			'uses'=>'Admin\PagesController@getTemplate'
		]);
		Route::get('/admin/get_latest_news',[
			'uses'=>'Admin\PagesController@getLatestNews'
		]);
		Route::get('/admin/get_page_content',[
			'uses'=>'Admin\PagesController@getPageContent'
		]);

	//Шаблоны
	Route::get('/admin/templates',[
		'as'=>'admin-templates',
		'uses'=>'Admin\TemplateController@index'
	]);
		Route::get('/admin/templates/add',[
			'as'=>'admin-templates-add',
			'uses'=>'Admin\TemplateController@addPage'
		]);
		Route::get('/admin/templates/edit/{id}',[
			'as'=>'admin-templates-edit',
			'uses'=>'Admin\TemplateController@editPage'
		]);
		Route::post('/admin/templates/add',[
			'uses'=>'Admin\TemplateController@addItem'
		]);
		Route::delete('/admin/templates/drop',[
			'uses'=>'Admin\TemplateController@dropItem'
		]);
	//Услуги
	Route::get('/admin/services',[
		'as'=>'admin-services',
		'uses'=>'Admin\ServicesController@index'
	]);
		Route::get('/admin/services/add',[
			'as'=>'admin-services-add',
			'uses'=>'Admin\ServicesController@addPage'
		]);
		Route::get('/admin/services/edit/{id}',[
			'as'=>'admin-services-edit',
			'uses'=>'Admin\ServicesController@editPage'
		]);
		Route::post('/admin/services/add',[
			'uses'=>'Admin\ServicesController@addItem'
		]);
		Route::delete('/admin/services/drop',[
			'uses'=>'Admin\ServicesController@dropItem'
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