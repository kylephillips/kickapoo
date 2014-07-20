<?php

/**
* Pages
*/
Route::get('/', ['as'=>'home','uses'=>'PageController@home']);


/**
* Admin
*/
Route::get('login', ['as'=>'login_form', 'uses'=>'SessionController@getLogin']);
Route::post('login', ['as'=>'login', 'uses'=>'SessionController@postLogin']);
Route::get('logout', ['as'=>'logout', 'uses'=>'SessionController@logout']);
Route::group(['before'=>'auth'], function()
{
	Route::get('admin', ['as'=>'admin_index', 'uses'=>'PageController@getAdmin']);
	Route::resource('admin/user', 'UserController');
	Route::get('admin/post/trash', ['as'=>'post_trash', 'uses'=>'PostController@getTrash']);
	Route::resource('admin/post', 'PostController');
	Route::post('searchterms', ['as'=>'update_search', 'uses'=>'PostController@updateSearchTerms']);
	Route::get('removePost', ['as'=>'remove_post', 'uses'=>'PostController@removePost']);
	Route::get('doimport', ['as'=>'do_import', 'uses'=>'FeedController@doImport']);
});


/**
* Social Feeds (Testing Only)
*/
Route::get('/feed/import', ['as'=>'import_feeds', 'uses'=>'FeedController@doImport']);
Route::get('/feed/twitter', ['as'=>'twitter_feed', 'uses'=>'FeedController@twitterFeed']);
Route::get('/feed/instagram', ['as'=>'instagram_feed', 'uses'=>'FeedController@instagramFeed']);