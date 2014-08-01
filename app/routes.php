<?php

/**
* Pages
*/
Route::get('/', ['as'=>'home','uses'=>'PageController@home']);


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
* View Composers
*/
View::composer('admin.partials.nav', 'Kickapoo\ViewComposers\AdminNavComposer');
View::composer(['partials.header', 'partials.footer'], 'Kickapoo\ViewComposers\HeaderViewComposer');
// Append query string to paginator
View::composer(Paginator::getViewName(), function($view) {
	$query = array_except( Input::query(), Paginator::getPageName() );
	$view->paginator->appends($query);
});
