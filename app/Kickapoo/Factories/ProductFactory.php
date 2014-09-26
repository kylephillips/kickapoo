<?php namespace Kickapoo\Factories;

use \Product;
use \Image;
use \Flavor;
use \ProductSize;
use \Str;
use Kickapoo\Repositories\ProductRepository;
use Kickapoo\Factories\UploadFactory;

class ProductFactory {

	/**
	* Product Repository
	*/
	protected $product_repo;


	public function __construct(ProductRepository $product_repo)
	{
		$this->product_repo = $product_repo;
	}

	/**
	* Create a new Product
	*/
	public function createProduct($input)
	{
		$image = ( $input['image'] !== "" ) ? $input['image'] : null;
		$content = ( isset($input['content']) ) ? $input['content'] : null;
		$css_class = ( isset($input['css_class']) ) ? $input['css_class'] : null;
		$language = ( isset($input['language']) ) ? $input['language'] : 'en';
		$flavor = Flavor::create([
			'title' => $input['title'],
			'slug' => \Str::slug($input['title']),
			'image' => null,
			'content' => $content,
			'css_class' => $css_class,
			'language' => $language,
			'upload_id' => $image
		]);
		if ( isset($input['new_product']) ) $this->addTypes($input['new_product'], $flavor->id);
		if ( isset($input['language']) ) $this->addTranslation($input['parent_flavor'], $flavor->id);
	}


	/**
	* Update a Product
	* @param id - integer
	* @param input - Input array
	*/
	public function updateProduct($id, $input)
	{
		$flavor = $this->product_repo->getFlavor($id);
		$flavor->title = $input['flavor_title'];
		$flavor->slug = \Str::slug($input['flavor_title']);
		$flavor->content = ( isset($input['flavor_content']) ) ? $input['flavor_content'] : null;
		$flavor->status = $input['status'];
		$flavor->upload_id = ( $input['flavor_image'] !== "" ) ? $input['flavor_image'] : null;
		$flavor->css_class = ( isset($input['css_class']) ) ? $input['css_class'] : null;
		$flavor->save();
		if ( isset($input['product']) ) $this->updateTypes($input['product'], $id);
		if ( isset($input['add_new']) ) $this->addTypes($input['new_product'], $id);
	}


	/**
	* Update attached product types
	* @param array
	*/
	public function updateTypes($types, $flavor_id)
	{
		foreach ( $types as $type ){
			$product = $this->product_repo->getProduct($type['product_id']);
			$product->content = ( isset($type['description']) ) ? $type['description'] : null;
			$product->ingredients = ( isset($type['ingredients']) ) ? $type['ingredients'] : null;
			$product->size_id = $type['size_id'];
			$product->flavor_id = $flavor_id;
			$product->image_id = ( $type['image'] !== "" ) ? $type['image'] : null;
			$product->nutrition_label_id = ( $type['nutrition_label'] !== "" ) ? $type['nutrition_label'] : null;
			$product->save();
		}
	}

	/**
	* Add new Product Types
	*/
	public function addTypes($types, $flavor_id)
	{
		foreach ( $types as $type ){
			$content = ( isset($type['description']) ) ? $type['description'] : null;
			$ingredients = ( isset($type['ingredients']) ) ? $type['ingredients'] : null;
			
			$image = ( $type['image'] !== "" ) ? $type['image'] : null;
			$nutrition_label = ( $type['nutrition_label'] !== "" ) ? $type['nutrition_label'] : null;
			
			Product::create([
				'flavor_id' => $flavor_id,
				'size_id' => $type['size'],
				'content' => $content,
				'ingredients' => $ingredients,
				'image_id' => $image,
				'nutrition_label_id' => $nutrition_label
			]);
		}
	}


	/**
	* Remove specified product type
	*/
	public function deleteProduct($id)
	{
		$product = $this->product_repo->getProduct($id);
		$product->delete();
	}


	/**
	* Upload an Image
	*/
	private function attachImage($file)
	{
		$upload = new UploadFactory;
		$upload = $upload->uploadImage($file, 'product_images');
		return basename($upload);
	}
	

	/**
	* Update the order of product
	*/
	public function updateOrder($products)
	{
		foreach($products as $key=>$product)
		{
			$product = $this->product_repo->getProduct($product);
			$product->order = $key;
			$product->save();
		}
	}


	/**
	* Update the order of flavors
	*/
	public function updateFlavorOrder($flavors)
	{
		foreach($flavors as $key=>$flavor)
		{
			$flavor = $this->product_repo->getFlavor($flavor);
			$flavor->order = $key;
			$flavor->save();
		}
	}


	/**
	* Add a new type/size
	*/
	public function addSize($input)
	{
		$language = ( isset($input['language']) ) ? $input['language'] : 'en';
		$size = ProductSize::create([
			'title' => $input['title'],
			'slug' => Str::slug($input['title']),
			'language' => $language
		]);
		return $size;
	}


	/**
	* Add Translation Record
	*/
	private function addTranslation($parent_flavor, $translated_flavor)
	{
		$parent = Flavor::find($parent_flavor);
		$parent->translations()->attach($translated_flavor);
	}

}