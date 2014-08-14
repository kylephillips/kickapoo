<?php namespace Kickapoo\Repositories;

use \Flavor;
use \Product;
use \ProductSize;

class ProductRepository {

	/**
	* Get all flavors with products/sizes
	*/
	public function getAll()
	{
		return Flavor::with('products', 'products.size')->get();
	}

	/**
	* Get a specified flavor with products/sizes
	*/
	public function getFlavor($id)
	{
		return Flavor::with('products', 'products.size')->findOrFail($id);
	}

	/**
	* Get all sizes and return as array
	*/
	public function getSizes()
	{
		$all_sizes = ProductSize::get()->toArray();
		foreach ($all_sizes as $size){
			$sizes[$size['id']] = $size['title'];
		}
		return $sizes;
	}

}