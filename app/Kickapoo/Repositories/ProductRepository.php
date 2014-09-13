<?php namespace Kickapoo\Repositories;

use \Flavor;
use \Product;
use \ProductSize;
use \LaravelLocalization;

class ProductRepository {

	/**
	* Get all flavors with products/sizes
	*/
	public function getAll()
	{
		return Flavor::with('products', 'products.size', 'products.size.translations')->orderBy('flavors.order')->get();
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
	public function getSizes($lang = 'en')
	{
		return ProductSize::with('translations', 'translation_of')->where('language', $lang)->get();
	}

	/**
	* Get a single size with an ID
	*/
	public function getSize($id)
	{
		return ProductSize::findOrFail($id);
	}

	/**
	* Get an individual product
	*/
	public function getProduct($id)
	{
		return Product::findOrFail($id);
	}


	/**
	* Get an array of all the translations
	* @return array
	*/
	public function getTranslationsArray($type = 'product', $id)
	{
		$parent = ( $type == 'product' ) ? $this->getProduct($id) : $this->getSize($id);

		$locales = LaravelLocalization::getSupportedLocales();
		$locale = array_get($locales, $parent['language']);

		$translations['en']['slug'] = $parent->slug;
		$translations['en']['native'] = $locale['native'];
		$translations['en']['name'] = $locale['name'];
		
		foreach ($parent->translations as $translation){
			$locale = array_get($locales, $translation['language']);
			$translations[$translation['language']]['slug'] = $translation->slug;
			$translations[$translation['language']]['title'] = $translation->title;
			$translations[$translation['language']]['id'] = $translation->id;
			$translations[$translation['language']]['native'] = $locale['native'];
			$translations[$translation['language']]['name'] = $locale['name'];
		}
		
		return $translations;
	}

}