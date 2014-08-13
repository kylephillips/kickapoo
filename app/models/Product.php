<?php
class Product extends Eloquent {

	protected $table = 'products';

	protected $fillable = [
		'flavor_id', 'size_id', 'ingredients', 'nutrition_label', 'content', 'image'
	];

	public function flavor()
	{
		return $this->hasOne('Flavor');
	}

	public function size()
	{
		return $this->hasOne('ProductSize');
	}

}