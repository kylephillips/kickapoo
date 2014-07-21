<?php
use Kickapoo\Repositories\PostRepository;

class PageController extends BaseController {

	/**
	* Posts Repository
	*/
	protected $posts_repo;


	public function __construct(PostRepository $posts_repo)
	{
		$this->posts_repo = $posts_repo;
	}


	/**
	* Homepage
	*/
	public function home()
	{	
		$posts = $this->posts_repo->getPosts();
		return View::make('home')
			->with('posts', $posts);
	}

	/**
	* Admin Homepage
	*/
	public function getAdmin()
	{
		return Redirect::route('admin.post.index');
	}

}