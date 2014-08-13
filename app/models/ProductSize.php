<?php
class ProductSize extends Eloquent {

	protected $table = 'productsizes';

	protected $fillable = [
		'title', 'slug'
	];

}