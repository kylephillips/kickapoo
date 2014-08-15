<?php namespace Kickapoo\Factories;

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
	* Update a Product
	*/
	public function updateProduct($id, $input)
	{
		$flavor = $this->product_repo->getFlavor($id);
		$flavor->title = $input['flavor_title'];
		$flavor->slug = \Str::slug($input['flavor_title']);
		$flavor->image = ( isset($input['flavor_image']) ) ? $this->attachImage($input['flavor_image']) : null;
		$flavor->content = $input['flavor_content'];
		$flavor->save();
	}


	/**
	* Upload an image
	* @return string
	*/
	private function attachImage($file)
	{
		$destination = public_path() . '/assets/uploads/product_images/';
		$filename = time() . '_' . $file->getClientOriginalName();
		try {
			$uploadSuccess = $file->move($destination, $filename);
			return $filename;
		} catch (\Exception $e) {
			return null;
		}
	}

}