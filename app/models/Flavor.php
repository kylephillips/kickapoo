<?php
class Flavor extends Eloquent {

	protected $table = 'flavors';

	protected $fillable = [
		'title', 'slug', 'content', 'image', 'css_class', 'order', 'language'
	];

	public function products()
	{
		return $this->hasMany('Product')
			->orderBy('products.order', 'asc');;
	}

	/**
	* Get translated flavor
	*/
	public function translations()
	{
		return $this->belongsToMany('Flavor', 'flavor_translations', 'parent_flavor', 'translated_flavor');
	}

	/**
	* Translation of
	*/
	public function translation_of()
	{
		return $this->belongsToMany('Flavor', 'flavor_translations', 'translated_flavor', 'parent_flavor');
	}

}