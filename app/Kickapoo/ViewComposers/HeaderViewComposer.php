<?php namespace Kickapoo\ViewComposers;

use Kickapoo\Repositories\SettingRepository;
use Kickapoo\Repositories\PageRepository;

class HeaderViewComposer {

	protected $settings_repo;

	protected $page_repo;

	protected $view_data;

	public function __construct(SettingRepository $settings_repo, PageRepository $page_repo)
	{
		$this->settings_repo = $settings_repo;
		$this->page_repo = $page_repo;
	}

	public function compose($view)
	{
		$this->view_data = $view->getData();
		$view->with('store_link', $this->storeLink());
		$view->with('social_links', $this->socialLinks());
		$view->with('translations', $this->getTranslations());
	}

	private function storeLink()
	{
		return $this->settings_repo->getSetting('store_link');
	}

	private function socialLinks()
	{
		return $this->settings_repo->socialLinks();
	}


	private function getTranslations()
	{
		if ( count($this->view_data['page']->translations) > 0 ){
			// Its english
			return $this->page_repo->getTranslationsArray($this->view_data['page']->id);
		} else {
			// Its a translation
			return $this->page_repo->getTranslationsArray($this->view_data['page']->translation_of[0]->id);
		}
	}

}