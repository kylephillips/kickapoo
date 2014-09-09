<?php namespace Kickapoo\ViewComposers;

use Kickapoo\Repositories\PageRepository;
use Kickapoo\Repositories\SettingRepository;

class PageViewComposer {

	protected $page_repo;
	protected $setting_repo;

	public function __construct(PageRepository $page_repo, SettingRepository $setting_repo)
	{
		$this->page_repo = $page_repo;
		$this->setting_repo = $setting_repo;
	}

	public function compose($view)
	{
		$view->with('page_navigation', $this->pageNav());
		$view->with('store_link', $this->storeLink());
	}

	private function pageNav()
	{
		return $this->page_repo->getNavigation();
	}

	private function storeLink()
	{
		return $this->setting_repo->getSetting('store_link');
	}

}