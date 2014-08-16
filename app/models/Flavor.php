<?php
class Flavor extends Eloquent {

	protected $table = 'flavors';

	protected $fillable = [
		'title', 'slug', 'content', 'image'
	];

	public function products()
	{
		return $this->hasMany('Product')
			->orderBy('products.order', 'asc');;
	}

}