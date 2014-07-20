<?php

use Kickapoo\Repositories\PostRepository;
use Kickapoo\Repositories\AppLogRepository;

class TrashController extends BaseController {

	/**
	* Log Repository
	*/
	protected $log_repo;

	/**
	* Post Repository
	*/
	protected $post_repo;


	public function __construct(AppLogRepository $log_repo, PostRepository $post_repo)
	{
		$this->log_repo = $log_repo;
		$this->post_repo = $post_repo;
	}

	/**
	 * Get a list of Posts in the trash
	 *
	 */
	public function index()
	{
		$last_trash = $this->log_repo->getLastTrash();
		$posts = $this->post_repo->getTrash();
		return View::make('admin.posts.trash')
			->with('last_trash', $last_trash)
			->with('posts', $posts);
	}


	/**
	 * Add an item to the trash
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function store()
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
	* Restore item from Trash
	*/
	public function restore()
	{
		if ( Request::ajax() ){
			$post = ( Input::get('type') == 'twitter' ) ? Tweet::findOrFail(Input::get('id')) : Gram::findOrFail(Input::get('id'));
			$post->approved = null;
			$post->save();
			return Response::json(['success'=>'Post Restored.']);
		}
	}

}