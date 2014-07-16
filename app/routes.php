<?php

Route::get('/', ['as'=>'home','uses'=>'PageController@home']);

/**
* Admin
*/
Route::get('login', ['as'=>'login_form', 'uses'=>'SessionController@getLogin']);
Route::post('login', ['as'=>'login', 'uses'=>'SessionController@postLogin']);
Route::get('logout', ['as'=>'logout', 'uses'=>'SessionController@logout']);


/**
* Social Feeds (Testing Only)
*/
Route::get('/feed/import', ['as'=>'import_feeds', 'uses'=>'FeedController@doImport']);
Route::get('/feed/twitter', ['as'=>'twitter_feed', 'uses'=>'FeedController@twitterFeed']);
Route::get('/feed/instagram', ['as'=>'instagram_feed', 'uses'=>'FeedController@instagramFeed']);