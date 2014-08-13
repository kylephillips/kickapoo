<?php
class Flavor extends Eloquent {

	protected $table = 'flavors';

	protected $fillable = [
		'title', 'slug', 'content', 'image'
	];

}