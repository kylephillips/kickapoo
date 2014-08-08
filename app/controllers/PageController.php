<?php
use Kickapoo\Repositories\PostRepository;
use Kickapoo\Repositories\PageRepository;

class PageController extends BaseController {

	/**
	* Posts Repository
	*/
	protected $posts_repo;

	/**
	* Page Repository
	*/
	protected $page_repo;


	public function __construct(PostRepository $posts_repo, PageRepository $page_repo)
	{
		$this->posts_repo = $posts_repo;
		$this->page_repo = $page_repo;
	}


	/**
	* Homepage
	*/
	public function home()
	{	
		$posts = $this->posts_repo->getApproved();
		
		return View::make('home')
			->with('page_slug', 'home')
			->with('posts', $posts);
	}

	/**
	* Admin Homepage
	*/
	public function getAdmin()
	{
		return Redirect::route('admin.post.index');
	}

	/**
	* Get Page
	*/
	public function getPage($slug)
	{

		$page = $this->page_repo->getPage($slug);
		$view = 'pages.' . $slug;

		return View::make($view)
			->with('page_slug', $slug)
			->with('page', $page);
	}

	/**
	* Edit Page
	*/
	public function edit($slug)
	{
		dd($slug);
		return $slug;
	}

}