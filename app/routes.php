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

	// Trash
	Route::get('remove-post', ['as'=>'remove_post', 'uses'=>'TrashController@store']);
	Route::post('restore-post', ['as'=>'restore_post', 'uses'=>'TrashController@restore']);
	Route::get('empty-trash', ['as'=>'empty_trash', 'uses'=>'TrashController@emptyTrash']);
	Route::post('delete-post', ['as'=>'delete_post', 'uses'=>'TrashController@deletePost']);

	// Imports
	Route::get('doimport', ['as'=>'do_import', 'uses'=>'FeedController@doImport']);
});


/**
* Social Feeds (Testing Only)
*/
Route::get('/feed/import', ['as'=>'import_feeds', 'uses'=>'FeedController@doImport']);
Route::get('/feed/twitter', ['as'=>'twitter_feed', 'uses'=>'FeedController@twitterFeed']);
Route::get('/feed/instagram', ['as'=>'instagram_feed', 'uses'=>'FeedController@instagramFeed']);