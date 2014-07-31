<?php namespace Kickapoo\ViewComposers;

use Kickapoo\Repositories\SettingRepository;

class HeaderViewComposer {

	protected $settings_repo;

	public function __construct(SettingRepository $settings_repo)
	{
		$this->settings_repo = $settings_repo;
	}

	public function compose($view)
	{
		$view->with('store_link', $this->storeLink());
	}

	private function storeLink()
	{
		return $this->settings_repo->getSetting('store_link');
	}



}