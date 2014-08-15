<?php
class ProductSize extends Eloquent {

	protected $table = 'productsizes';

	protected $fillable = [
		'title', 'slug'
	];

	public static $required = [
		'title' => 'required|unique:productsizes,title'
	];

}