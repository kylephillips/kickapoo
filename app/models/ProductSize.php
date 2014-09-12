<?php
class ProductSize extends Eloquent {

	protected $table = 'productsizes';

	protected $fillable = [
		'title', 'slug', 'language'
	];

	public static $required = [
		'title' => 'required|unique:productsizes,title'
	];

	/**
	* Get translated sizes
	*/
	public function translations()
	{
		return $this->belongsToMany('ProductSize', 'productsizes_translations', 'parent_size', 'translated_size');
	}

	/**
	* Translation of
	*/
	public function translation_of()
	{
		return $this->belongsToMany('ProductSize', 'productsizes_translations', 'translated_size', 'parent_size');
	}

}