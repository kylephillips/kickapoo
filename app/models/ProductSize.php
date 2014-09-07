<?php
class ProductSize extends Eloquent {

	protected $table = 'productsizes';

	protected $fillable = [
		'title', 'slug', 'language'
	];

	public static $required = [
		'title' => 'required|unique:productsizes,title'
	];

}