<?php
class Trash extends Eloquent {

	protected $table = 'trash';

	protected $fillable = ['type', 'twitter_id', 'instagram_id', 'facebook_id'];

}