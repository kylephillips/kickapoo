<?php

use Kickapoo\Repositories\PageRepository;
use Kickapoo\Repositories\ProductRepository;

class ProductController extends \BaseController {

	/**
	* Page Repository
	*/
	protected $page_repo;

	/**
	* Product Repository
	*/
	protected $product_repo;

	public function __construct(PageRepository $page_repo, ProductRepository $product_repo)
	{
		$this->beforeFilter('auth', ['except'=>'index']);
		$this->page_repo = $page_repo;
		$this->product_repo = $product_repo;
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
		$sizes = $this->product_repo->getSizes();

		return View::make('admin.products.edit')
			->with('flavor', $flavor)
			->with('sizes', $sizes);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
