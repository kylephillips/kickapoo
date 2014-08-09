<?php

use Kickapoo\Repositories\SettingRepository;
use Kickapoo\Factories\SettingFactory;
use Kickapoo\Repositories\PostRepository;
use Kickapoo\Repositories\AppLogRepository;
use Kickapoo\Factories\PostFactory;

class PostController extends \BaseController {

	/**
	* Settings Repository
	*/
	protected $settings_repo;

	/**
	* Settings Factory
	*/
	protected $settings_factory;

	/**
	* Posts Repository
	*/
	protected $post_repo;

	/**
	* Log Repository
	*/
	protected $log_repo;


	public function __construct(SettingRepository $settings_repo, SettingFactory $settings_factory, PostRepository $post_repo, AppLogRepository $log_repo)
	{
		$this->settings_repo = $settings_repo;
		$this->settings_factory = $settings_factory;
		$this->post_repo = $post_repo;
		$this->log_repo = $log_repo;
	}


	/**
	 * List of all pending & approved Posts
	 *
	 * @return Response
	 */
	public function index()
	{
		$twitter_search = $this->settings_repo->twitterSearch();
		$instagram_search = $this->settings_repo->instagramSearch();
		$last_import = $this->log_repo->getLastImport();
		$pending_count = $this->post_repo->getPendingCount();

		$type = ( isset($_GET['type']) ) ? $_GET['type'] : 'all';
		$status = ( isset($_GET['status']) ) ? $_GET['status'] : 'all';
		$posts = $this->post_repo->getPosts($type, $status);

		$type_link = URL::route('admin.post.index');
		$type_link .= ( $status !== 'all' ) ? '?status=' . $status : '?status=all';

		$status_link = URL::route('admin.post.index');
		$status_link .= ( $type !== 'all' ) ? '?type=' . $type : '?type=all';

		// Paginate Posts
		$perPage = 5;
		$currentPage = Input::get('page', 1) - 1;
		$current_posts = array_slice($posts->toArray(), $currentPage * $perPage, $perPage);
		$posts = Paginator::make($current_posts, count($posts), $perPage);
		$num_posts = count($posts);

		return View::make('admin.posts.post')
			->with('twitter_search', $twitter_search)
			->with('instagram_search', $instagram_search)
			->with('posts', $posts)
			->with('last_import', $last_import)
			->with('num_posts', $num_posts)
			->with('pending_count', $pending_count)
			->with('type', ucfirst($type))
			->with('status', ucfirst($status))
			->with('type_link', $type_link)
			->with('status_link', $status_link);
	}


	/**
	 * Store an approved post
	 */
	public function store()
	{
		$newpost = new PostFactory;
		$newpost = $newpost->savePost(Input::get('id'), Input::get('type'));

		$approval_date = date('D, M jS y - g:i a', strtotime($newpost->created_at));
		return Response::json([
			'status' => 'success', 
			'approval_date'=>$approval_date, 
			'postid'=>$newpost->id,
			'firstname' => $newpost->user->first_name,
			'lastname' => $newpost->user->last_name
		]);
	}


	/**
	* Update the social search terms
	*/
	public function updateSearchTerms()
	{
		$validation = Validator::make(Input::all(), Setting::$search_required);
		
		if ( $validation->fails() ){
			return Redirect::back()
				->withErrors($validation)
				->withInput();
		}

		$this->settings_factory->updateSearchTerms(Input::all());
		return Redirect::route('admin.post.index')
			->with('searchsuccess', 'Search Terms Updated. This will take effect during the next import.');
	}


	/**
	* Get Pending count
	*/
	public function getPending()
	{
		if ( Request::ajax() ){
			return $this->post_repo->getPendingCount();
		}
	}


}
