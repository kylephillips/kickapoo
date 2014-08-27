<?php

use Kickapoo\Repositories\PageRepository;
use Kickapoo\Repositories\ProductRepository;
use Kickapoo\Factories\ProductFactory;

class ProductController extends \BaseController {

	/**
	* Page Repository
	*/
	protected $page_repo;

	/**
	* Product Repository
	*/
	protected $product_repo;

	/**
	* Product Factory
	*/
	protected $product_factory;

	public function __construct(PageRepository $page_repo, ProductRepository $product_repo, ProductFactory $product_factory)
	{
		$this->beforeFilter('auth', ['except'=>['index','modalInfo']]);
		$this->page_repo = $page_repo;
		$this->product_repo = $product_repo;
		$this->product_factory = $product_factory;
	}


	/**
	 * Front end product listing
	 */
	public function index()
	{
		$page = $this->page_repo->getPage('products');
		$flavors = $this->product_repo->getAll();

		return View::make('pages.products')
			->with('page', $page)
			->with('page_slug', $page['slug'])
			->with('flavors', $flavors);
	}


	/**
	 * Admin product listing
	 */
	public function adminIndex()
	{
		$flavors = $this->product_repo->getAll();
		return View::make('admin.products.index')
			->with('flavors', $flavors);
	}


	/**
	 * Show the form for creating a new flavor.
	 */
	public function create()
	{
		$sizes = $this->product_repo->getSizesArray();
		return View::make('admin.products.create')
			->with('sizes', $sizes);
	}


	/**
	 * Store a new flavor
	 */
	public function store()
	{
		$validation = Validator::make(Input::all(), ['title'=>'required|unique:flavors,title']);
		if ( $validation->fails() ) return Redirect::back()->withErrors($validation);

		$this->product_factory->createProduct(Input::all());

		return Redirect::route('edit_products')
			->with('success', 'Product successfully added.');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$flavor = $this->product_repo->getFlavor($id);
		$sizes = $this->product_repo->getSizesArray();

		return View::make('admin.products.edit')
			->with('flavor', $flavor)
			->with('sizes', $sizes);
	}


	/**
	 * Update the Flavor.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validation = Validator::make(Input::all(), ['flavor_title'=>'required|unique:flavors,title,' . $id]);
		if ( $validation->fails() ) return Redirect::back()->withErrors($validation);

		$this->product_factory->updateProduct($id, Input::all());

		return Redirect::route('edit_flavor', ['id'=>$id])
			->with('success', 'Product successfully updated.');
	}


	/**
	* Delete an individual product (ajax)
	*/
	public function deleteProduct()
	{
		if ( Request::ajax() ){
			$this->product_factory->deleteProduct(Input::get('id'));
			return Response::json(['status'=>'success']);
		}
	}


	/**
	* Set the order of products for a given flavor
	*/
	public function setOrder()
	{
		$products = explode(',', Input::get('order'));
		$this->product_factory->updateOrder($products);
		return Response::json(['status'=>'success']);
	}


	/**
	* Set the order of flavors
	*/
	public function flavorOrder()
	{
		$flavors = explode(',', Input::get('order'));
		$this->product_factory->updateFlavorOrder($flavors);
		return Response::json(['status'=>'success']);
	}


	/**
	 * Remove the flavor/products
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		$flavor = $this->product_repo->getFlavor($id);
		$flavor->delete();
		return Response::json(['status'=>'success']);
	}


	/**
	* Get Info for display in modal window
	*/
	public function modalInfo()
	{
		$product = $this->product_repo->getProduct(Input::get('id'));
		$nutrition = $product->nutrition_label;
		$ingredients = $product->ingredients;
		$content = $product->content;
		return Response::json([
			'status'=>'success', 
			'nutrition'=>$nutrition, 
			'ingredients'=>$ingredients,
			'content'=>$content
		]);
	}


}
