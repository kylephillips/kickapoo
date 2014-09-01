<?php
/**
* Pages (Catch-all below other routes)
*/
Route::group(array(
	'prefix' => LaravelLocalization::setLocale(),
	'before' => 'LaravelLocalizationRedirectFilter'
	), function(){
	Route::get('/', ['as'=>'home','uses'=>'PageController@home']);
	Route::get('products', ['as'=>'products', 'uses'=>'ProductController@index']);
});
Route::get('modal-info', ['as'=>'modal_info', 'uses'=>'ProductController@modalInfo']);

/**
* Forms
*/
Route::post('/form-submit', ['before'=>'csrf', 'as'=>'process_form', 'uses'=>'ContactFormController@process']);

/**
* Admin Login
*/
Route::get('login', ['as'=>'login_form', 'uses'=>'SessionController@getLogin']);
Route::post('login', ['as'=>'login', 'uses'=>'SessionController@postLogin']);
Route::get('logout', ['as'=>'logout', 'uses'=>'SessionController@logout']);
Route::controller('password', 'RemindersController');


/**
* Admin Authorized
*/
Route::group(['before'=>'auth'], function()
{
	Route::get('admin', ['as'=>'admin_index', 'uses'=>'PageController@getAdmin']);

	// User Management
	Route::resource('admin/user', 'UserController');

	// Post Management
	Route::get('admin/post/trash', ['as'=>'post_trash', 'uses'=>'TrashController@index']);
	Route::resource('admin/post', 'PostController');
	Route::get('admin/pending-count', ['as'=>'pending_count', 'uses'=>'PostController@getPending']);

	// Page Management
	Route::get('admin/pages', ['as'=>'page_index', 'uses'=>'PageController@index']);
	Route::get('admin/pages/edit/{slug}', ['as'=>'edit_page', 'uses'=>'PageController@edit']);
	Route::post('admin/pages/edit/{id}', ['as'=>'update_page', 'uses'=>'PageController@update']);
	Route::get('admin/pages/create', ['as'=>'create_page', 'uses'=>'PageController@create']);
	Route::post('admin/pages/create', ['as'=>'store_page', 'uses'=>'PageController@store']);
	Route::get('admin/pages/destroy/{slug}', ['as'=>'destroy_page', 'uses'=>'PageController@destroy']);
	Route::get('admin/pages/order', ['as'=>'order_pages', 'uses'=>'PageController@setOrder']);
	Route::post('admin/pages/menutoggle', ['as'=>'menu_toggle', 'uses'=>'PageController@menuToggle']);

	// Custom Field Management
	Route::post('admin/customfield/validate', ['as'=>'validate_custom_fields', 'uses'=>'CustomFieldController@validate']);
	Route::get('admin/customfield/destroy/{id}', ['as'=>'destroy_custom_field', 'uses'=>'CustomFieldController@destroy']);

	// Product/Flavor Management
	Route::get('admin/products', ['as'=>'edit_products', 'uses'=>'ProductController@adminIndex']);
	Route::get('admin/products/edit/{id}', ['as'=>'edit_flavor', 'uses'=>'ProductController@edit']);
	Route::post('admin/products/edit/{id}', ['as'=>'update_flavor', 'uses'=>'ProductController@update']);
	Route::get('admin/products/create', ['as'=>'create_flavor', 'uses'=>'ProductController@create']);
	Route::post('admin/products/create', ['as'=>'store_flavor', 'uses'=>'ProductController@store']);
	Route::get('admin/flavor/delete/{id}', ['as'=>'delete_flavor', 'uses'=>'ProductController@destroy']);
	Route::get('admin/flavor/order', ['as'=>'flavor_order', 'uses'=>'ProductController@flavorOrder']);
	Route::get('admin/product/delete', ['as'=>'delete_product', 'uses'=>'ProductController@deleteProduct']);
	Route::get('admin/products/order', ['as'=>'product_order', 'uses'=>'ProductController@setOrder']);
	Route::resource('admin/size', 'ProductSizeController', ['only'=>['index','store']]);
	Route::get('admin/size/delete', ['as'=>'delete_size', 'uses'=>'ProductSizeController@delete']);
	Route::post('admin/size/update', ['as'=>'update_size', 'uses'=>'ProductSizeController@update']);

	// Form Entry Management
	Route::get('admin/forms', ['as'=>'form_entries', 'uses'=>'ContactFormController@index']);
	Route::get('admin/forms/delete', ['as'=>'delete_form_entry', 'uses'=>'ContactFormController@destroy']);
	Route::post('admin/forms/bulk-delete', ['as'=>'bulk_delete_form_entries', 'uses'=>'ContactFormController@bulkDelete']);

	// Media Management
	Route::post('admin/media/editor-upload', ['as'=>'editor_upload', 'uses'=>'UploadController@editorUpload']);

	// Social Search Terms
	Route::post('searchterms', ['as'=>'update_search', 'uses'=>'PostController@updateSearchTerms']);

	// Settings Management
	Route::get('admin/settings', ['as'=>'settings_form', 'uses'=>'SettingController@index']);
	Route::post('admin/settings', ['as'=>'update_settings', 'uses'=>'SettingController@update']);

	// Trash
	Route::get('remove-post', ['as'=>'remove_post', 'uses'=>'TrashController@store']);
	Route::post('restore-post', ['as'=>'restore_post', 'uses'=>'TrashController@restore']);
	Route::get('empty-trash', ['as'=>'empty_trash', 'uses'=>'TrashController@emptyTrash']);
	Route::post('delete-post', ['as'=>'delete_post', 'uses'=>'TrashController@deletePost']);
	Route::post('trash-banned', ['as'=>'trash_banned', 'uses'=>'TrashController@trashBanned']);

	// Imports
	Route::get('do-import', ['as'=>'do_import', 'uses'=>'ImportController@doImport']);
	Route::post('import-single', ['as'=>'import_single', 'uses'=>'ImportController@importPost']);

	// User Banning
	Route::get('admin/ban/unban', ['as'=>'unban', 'uses'=>'BanController@unban']);
	Route::resource('admin/ban', 'BanController', ['only'=>['index','store']]);
});

/**
* Front end pages
*/
Route::group(array(
	'prefix' => LaravelLocalization::setLocale(),
	'before' => 'LaravelLocalizationRedirectFilter'
	), function(){
	Route::get('/{page}', ['as'=>'page', 'uses'=>'PageController@getPage']);
});


/**
* View Composers
*/
View::composer('*', 'Kickapoo\ViewComposers\PageViewComposer');
View::composer('admin.partials.nav', 'Kickapoo\ViewComposers\AdminNavComposer');
View::composer(['partials.header', 'partials.footer', 'partials.mobilenav'], 'Kickapoo\ViewComposers\HeaderViewComposer');

// Append query string to paginator
View::composer(Paginator::getViewName(), function($view) {
	$query = array_except( Input::query(), Paginator::getPageName() );
	$view->paginator->appends($query);
});
