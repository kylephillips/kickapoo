<?php

use Kickapoo\Repositories\SettingRepository;
use Kickapoo\Factories\SettingFactory;
use Kickapoo\Repositories\PostRepository;
use Kickapoo\Repositories\AppLogRepository;

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
		$posts = $this->post_repo->getPosts();
		$last_import = $this->log_repo->getLastImport();

		// Paginate Posts
		$perPage = 5;
		$currentPage = Input::get('page', 1) - 1;
		$current_posts = array_slice($posts->toArray(), $currentPage * $perPage, $perPage);
		$posts = Paginator::make($current_posts, count($posts), $perPage);

		return View::make('admin.posts.post')
			->with('twitter_search', $twitter_search)
			->with('instagram_search', $instagram_search)
			->with('posts', $posts)
			->with('last_import', $last_import);
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
	 * Store an approved post
	 *
	 */
	public function store()
	{
		$type = Input::get('type');
		$id = Input::get('id');
		$post = ( $type == 'twitter' ) ? Tweet::findOrFail($id) : Gram::findOrFail($id);

		$tweet_id = ( $type == 'twitter' ) ? $post->id : null;
		$gram_id = ( $type != 'twitter' ) ? $post->id : null;
		$post->approved = 1;
		$post->save();

		$newpost = Post::create([
			'type' => $type,
			'tweet_id' => $tweet_id,
			'gram_id' => $gram_id
		]);

		$approval_date = date('D, M jS y - g:i a', strtotime($newpost->created_at));
		return Response::json(['status' => 'success', 'approval_date'=>$approval_date, 'postid'=>$newpost->id]);
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
	 * Remove the post from the list of pending approval
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function removePost()
	{
		if ( Request::ajax() ) {
			$post = ( Input::get('type') == 'twitter' ) ? Tweet::findOrFail(Input::get('id')) : Gram::findOrFail(Input::get('id'));
			$post->approved = 0;
			$post->save();
			if ( Input::get('postid') ){
				$post = Post::findOrFail(Input::get('postid'));
				$post->delete();
			}
			return Response::json('success');
		}
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


}
