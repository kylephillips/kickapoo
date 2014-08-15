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
	public function getSizesArray()
	{
		$all_sizes = ProductSize::get()->toArray();
		foreach ($all_sizes as $size){
			$sizes[$size['id']] = $size['title'];
		}
		return $sizes;
	}

	/**
	* Get Sizes Eloquent Object
	*/
	public function getSizes()
	{
		return ProductSize::get();
	}

	/**
	* Get a single size with an ID
	*/
	public function getSize($id)
	{
		return ProductSize::findOrFail($id);
	}

}