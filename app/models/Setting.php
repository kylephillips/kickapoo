<?php
class Setting extends Eloquent {

	protected $table = 'settings';
	protected $fillable = ['key', 'value'];

	public static $search_required = [
		'twitter_search' => 'required',
		'instagram_search' => 'required'
	];

}