<?php namespace Kickapoo\Factories;

use \Product;
use \Image;
use \Flavor;
use \ProductSize;
use \Str;
use Kickapoo\Repositories\ProductRepository;

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
		$image = ( isset($input['image']) ) ? $this->attachImage($input['image']) : null;
		$content = ( isset($input['content']) ) ? $input['content'] : null;
		$css_class = ( isset($input['css_class']) ) ? $input['css_class'] : null;
		$flavor = Flavor::create([
			'title' => $input['title'],
			'slug' => \Str::slug($input['title']),
			'image' => $image,
			'content' => $content,
			'css_class' => $css_class
		]);
		if ( isset($input['new_product']) ) $this->addTypes($input['new_product'], $flavor->id);
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
		if ( isset($input['flavor_image']) ) $flavor->image = $this->attachImage($input['flavor_image']);
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
			if ( isset($type['image']) ) $product->image = $this->attachImage($type['image']);
			if ( isset($type['nutrition_label']) ) $product->nutrition_label = $this->attachImage($type['nutrition_label']);
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
			
			$image = ( isset($type['image']) ) ? $this->attachImage($type['image']) : null;
			$nutrition_label = ( isset($type['nutrition_label']) ) ? $this->attachImage($type['nutrition_label']) : null;
			
			Product::create([
				'flavor_id' => $flavor_id,
				'size_id' => $type['size'],
				'content' => $content,
				'ingredients' => $ingredients,
				'image' => $image,
				'nutrition_label' => $nutrition_label
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
	* Upload an image to the product images directory
	* @return string
	*/
	private function attachImage($file)
	{
		$destination = public_path() . '/assets/uploads/product_images/';
		$thumbnail_destination = public_path() . '/assets/uploads/product_images/_thumbs/';
		$filename = time() . '_' . $file->getClientOriginalName();
		try {
			$thumb = Image::make($file)->crop(100,100)->save($thumbnail_destination . $filename, 80);
			$uploadSuccess = $file->move($destination, $filename);
			return $filename;
		} catch (\Exception $e) {
			dd($e);
			return null;
		}
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
		$size =ProductSize::create([
			'title' => $input['title'],
			'slug' => Str::slug($input['title']),
			'language' => $language
		]);
		return $size;
	}

}