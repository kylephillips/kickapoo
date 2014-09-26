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
		$page = $this->page_repo->getPage('products', LaravelLocalization::getCurrentLocale());
		$flavors = $this->product_repo->getAll($status = 'publish', $language = LaravelLocalization::getCurrentLocale());

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
		// Slug Validation for Translations
		if ( Input::get('language') ){
			$slug = Str::slug(Input::get('flavor_title') . '-' . Input::get('language'));
		} else {
			$slug = Str::slug(Input::get('flavor_title'));
		}

		$validation = Validator::make([
			'title' => Input::get('flavor_title'),
			'slug' => $slug
			], [
			'title' => 'required',
			'slug' => 'unique:flavors,slug'
		]);
		
		if ( $validation->fails() ) return Redirect::back()->withErrors($validation);

		$this->product_factory->createProduct(Input::all());

		return Redirect::route('edit_products')
			->with('success', 'Product successfully added.');
	}


	/**
	* Add a Flavor Translation
	*/
	public function addTranslation()
	{
		$sizes = $this->product_repo->getSizesArray();
		$language = Input::get('language');
		$language_name = Input::get('language_name');
		$parent_flavor = $this->product_repo->getFlavor(Input::get('parent_flavor'));

		return View::make('admin.products.create')
			->with('sizes', $sizes)
			->with('parent_flavor', $parent_flavor)
			->with('language', $language)
			->with('language_name', $language_name);
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
		$translations = $this->product_repo->getTranslationsArray('flavor', $id);

		return View::make('admin.products.edit')
			->with('flavor', $flavor)
			->with('sizes', $sizes)
			->with('translations', $translations);
	}


	/**
	 * Update the Flavor.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Slug Validation for Translations
		if ( Input::get('language') ){
			$slug = Str::slug(Input::get('flavor_title') . '-' . Input::get('language'));
		} else {
			$slug = Str::slug(Input::get('flavor_title'));
		}

		$validation = Validator::make([
			'title' => Input::get('flavor_title'),
			'slug' => $slug
			], [
			'title' => 'required',
			'slug' => 'unique:flavors,slug,' . $id
		]);	

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
		$nutrition = ( Input::get('content') == 'ingredients') ? null : $product->nutrition_upload->folder . $product->nutrition_upload->file;
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
