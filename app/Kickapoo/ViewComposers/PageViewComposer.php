<?php namespace Kickapoo\ViewComposers;

use Kickapoo\Repositories\PageRepository;
use Kickapoo\Repositories\SettingRepository;
use \LaravelLocalization;

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
		$view->with('media_page', $this->mediaPage());
	}

	private function pageNav()
	{
		return $this->page_repo->getNavigation();
	}

	private function storeLink()
	{
		return $this->setting_repo->getSetting('store_link');
	}

	private function mediaPage()
	{
		return $this->page_repo->getPage('media', LaravelLocalization::getCurrentLocale());
	}

}