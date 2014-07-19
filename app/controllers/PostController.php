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
		$last_import = $this->log_repo->getLast();

		$perPage = 10;
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
	 * Store a new post – approved
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
	 * Remove the post from the list of pending approval
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function removePost()
	{
		if ( Request::ajax() ) {
			if ( Input::get('type') == 'twitter' ){			
				$post = Tweet::findOrFail(Input::get('id'));
				$post->approved = 0;
				$post->save();
				return Response::json('success');
			} else {
				$post = Gram::findOrFail(Input::get('id'));
				$post->approved = 0;
				$post->save();
				return Response::json('success');
			}
		}
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
