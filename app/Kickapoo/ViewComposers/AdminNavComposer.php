<?php namespace Kickapoo\ViewComposers;

use Kickapoo\Repositories\PostRepository;

class AdminNavComposer {

	protected $post_repo;

	public function __construct(PostRepository $post_repo)
	{
		$this->post_repo = $post_repo;
	}

	public function compose($view)
	{
		$view->with('trashcount', $this->trashCount());
	}

	private function trashCount()
	{
		return $this->post_repo->trashCount();
	}

}