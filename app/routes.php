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

	// Social Search Terms
	Route::post('searchterms', ['as'=>'update_search', 'uses'=>'PostController@updateSearchTerms']);

	// Settings Management
	Route::resource('admin/settings', 'SettingController@index', ['only'=>['update','index']]);

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
