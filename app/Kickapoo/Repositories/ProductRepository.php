<?php namespace Kickapoo\Repositories;

use \Flavor;
use \Product;
use \ProductSize;
use \LaravelLocalization;

class ProductRepository {

	/**
	* Get all flavors with products/sizes
	*/
	public function getAll($lang = 'en')
	{
		return Flavor::where('language', $lang)->with('products', 'products.size', 'products.size.translations')->orderBy('flavors.order')->get();
	}

	/**
	* Get a specified flavor with products/sizes
	*/
	public function getFlavor($id)
	{
		return Flavor::with('products', 'products.size', 'translations', 'translation_of')->findOrFail($id);
	}

	/**
	* Get all sizes and return as array
	*/
	public function getSizesArray()
	{
		$all_sizes = ProductSize::where('language','en')->get()->toArray();
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
	* Get an array of all the translations for either a product or a type/size
	* @return array
	*/
	public function getTranslationsArray($type = 'flavor', $id)
	{
		$parent = ( $type == 'flavor' ) ? $this->getFlavor($id) : $this->getSize($id);

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