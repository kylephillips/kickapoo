<?php

Route::get('/', ['as'=>'home','uses'=>'PageController@home']);


/**
* Social Feeds (Testing Only)
*/
Route::get('/feed/import', ['as'=>'import_feeds', 'uses'=>'FeedController@doImport']);
Route::get('/feed/twitter', ['as'=>'twitter_feed', 'uses'=>'FeedController@twitterFeed']);
Route::get('/feed/instagram', ['as'=>'instagram_feed', 'uses'=>'FeedController@instagramFeed']);