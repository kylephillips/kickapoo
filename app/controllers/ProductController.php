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
		$this->beforeFilter('auth', ['except'=>'index']);
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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
