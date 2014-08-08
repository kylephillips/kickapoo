<?php namespace Kickapoo\ViewComposers;

use Kickapoo\Repositories\PageRepository;

class PageViewComposer {

	protected $page_repo;

	public function __construct(PageRepository $page_repo)
	{
		$this->page_repo = $page_repo;
	}

	public function compose($view)
	{
		$view->with('page_navigation', $this->pageNav());
	}

	private function pageNav()
	{
		return $this->page_repo->getNavigation();
	}

}