<?php
class Flavor extends Eloquent {

	protected $table = 'flavors';

	protected $fillable = [
		'title', 'slug', 'content', 'image', 'css_class', 'order', 'status'
	];

	public function products()
	{
		return $this->hasMany('Product')
			->orderBy('products.order', 'asc');;
	}

}