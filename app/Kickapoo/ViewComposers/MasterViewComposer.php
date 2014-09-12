<?php namespace Kickapoo\ViewComposers;

use Kickapoo\Repositories\SettingRepository;

class MasterViewComposer {

	protected $settings_repo;

	public function __construct(SettingRepository $settings_repo)
	{
		$this->settings_repo = $settings_repo;
	}

	public function compose($view)
	{
		$view->with('footer_scripts', $this->footerScripts());
	}

	private function footerScripts()
	{
		return $this->settings_repo->getSetting('footer_scripts');
	}

}