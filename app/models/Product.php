<?php
class Product extends Eloquent {

	protected $table = 'products';

	protected $fillable = [
		'flavor_id', 'size_id', 'ingredients', 'nutrition_label', 'content', 'image', 'order', 'image_id', 'nutrition_label_id'
	];

	public function flavor()
	{
		return $this->hasOne('Flavor');
	}

	public function size()
	{
		return $this->belongsTo('ProductSize');
	}

	public function upload()
	{
		return $this->hasOne('Upload', 'id', 'image_id');
	}

	public function nutrition_upload()
	{
		return $this->hasOne('Upload', 'id', 'nutrition_label_id');
	}

}