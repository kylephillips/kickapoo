<?php

use Kickapoo\Repositories\ProductRepository;

class ProductSizeController extends \BaseController {

	/**
	* Product Repository
	*/
	protected $product_repo;


	public function __construct(ProductRepository $product_repo)
	{
		$this->product_repo = $product_repo;
	}


	/**
	 * Show all the sizes.
	 */
	public function index()
	{
		$sizes = $this->product_repo->getSizes();
		foreach( $sizes as $size ){
			$translations[$size->id] = $this->product_repo->getTranslationsArray('size', $size->id);
		}
		//dd($translations);
		return View::make('admin.products.sizes')
			->with('sizes', $sizes)
			->with('translations', $translations);
	}


	/**
	 * Store a new size.
	 */
	public function store()
	{
		$validation = Validator::make(Input::all(), ProductSize::$required);
		if ( $validation->fails() ){
			return Redirect::back()->withInput()->withErrors($validation);
		}
		$language = ( Input::get('language') ) ? Input::get('language') : 'en';
		ProductSize::create([
			'title' => Input::get('title'),
			'slug' => Str::slug(Input::get('title')),
			'language' => $language
		]);
		return Redirect::route('admin.size.index')
			->with('success', 'Size successfully added.');
	}


	/**
	 * Update the size
	 */
	public function update()
	{
		$size = $this->product_repo->getSize(Input::get('id'));

		$validation = Validator::make(Input::all(), [
			'id' => 'required',
			'title' => 'required'
		]);
		$validation->sometimes('title', 'unique:productsizes,title', function($input) use ($size) {
			return $input->title !== $size->title;
		});

		if ( $validation->fails() ){
			return Response::json(['status'=>'error', 'message'=>$validation->getMessageBag()->first()]);
		}

		$size->title = Input::get('title');
		$size->slug = Str::slug(Input::get('title'));
		$size->save();
		
		return Response::json(['status'=>'success']);
	}


	/**
	 * Delete a Size (AJAX only)
	 */
	public function delete()
	{
		if ( Request::ajax() ){
			$size = $this->product_repo->getSize(Input::get('id'));
			$size->delete();
			return Response::json(['status'=>'success']);
		}
	}


}
