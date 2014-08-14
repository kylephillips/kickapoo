<?php

use Kickapoo\Repositories\PageRepository;

class ProductController extends \BaseController {

	/**
	* Page Repository
	*/
	protected $page_repo;

	public function __construct(PageRepository $page_repo)
	{
		$this->beforeFilter('auth', ['except'=>'index']);
		$this->page_repo = $page_repo;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$page = $this->page_repo->getPage('products');
		$flavors = Flavor::with('products', 'products.size')->get();

		return View::make('pages.products')
			->with('page', $page)
			->with('page_slug', $page['slug'])
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
		//
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
