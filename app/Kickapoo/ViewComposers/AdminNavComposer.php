<?php namespace Kickapoo\ViewComposers;

use Kickapoo\Repositories\PostRepository;
use Kickapoo\Repositories\PageRepository;

class AdminNavComposer {

	protected $post_repo;

	protected $page_repo;

	public function __construct(PostRepository $post_repo, PageRepository $page_repo)
	{
		$this->post_repo = $post_repo;
		$this->page_repo = $page_repo;
	}

	public function compose($view)
	{
		$view->with('trashcount', $this->trashCount());
		$view->with('pendingcount', $this->pendingCount());
		$view->with('allpages', $this->getPages());
	}

	private function trashCount()
	{
		return $this->post_repo->trashCount();
	}

	private function pendingCount()
	{
		return $this->post_repo->getPendingCount();
	}

	private function getPages()
	{
		return $this->page_repo->getAllPages();
	}

}