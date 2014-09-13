<?php

use Kickapoo\Repositories\ProductRepository;
use Kickapoo\Factories\ProductFactory;

class ProductSizeController extends \BaseController {

	/**
	* Product Repository
	*/
	protected $product_repo;

	/**
	* Product Factory
	*/
	protected $product_factory;


	public function __construct(ProductRepository $product_repo, ProductFactory $product_factory)
	{
		$this->product_repo = $product_repo;
		$this->product_factory = $product_factory;
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
		$this->product_factory->addSize(Input::all());
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

			foreach($size->translations as $translation){
				$trans = $this->product_repo->getSize($translation->id);
				$trans->delete();
			}

			$size->delete();

			return Response::json(['status'=>'success']);
		}
	}


	/**
	* Add a Translation of a size
	*/
	public function addTranslation()
	{
		if ( Request::ajax() ){
			$validation = Validator::make(Input::all(), ProductSize::$translation_required);
			
			if ( $validation->fails() ){
				return Response::json(['status'=>'error', 'message'=>$validation->getMessageBag()->first()]);
			}

			$translated_size = $this->product_factory->addSize(Input::all());
			$parent = $this->product_repo->getSize(Input::get('parent'));
			$parent->translations()->attach($translated_size);

			return Response::json(['status'=>'success']);
		}
	}


}
