<?php
use Kickapoo\Repositories\SettingRepository;
use Kickapoo\Factories\SettingFactory;

class SettingController extends \BaseController {

	/**
	* Settings Repository
	*/
	protected $settings_repo;

	/**
	* Settings Factory
	*/
	protected $settings_factory;


	public function __construct(SettingRepository $settings_repo, SettingFactory $settings_factory)
	{
		$this->beforeFilter('admin');
		$this->settings_repo = $settings_repo;
		$this->settings_factory = $settings_factory;
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 */
	public function index()
	{
		$social_creds = $this->settings_repo->socialCreds();
		$social_links = $this->settings_repo->socialLinks();
		$store_link = $this->settings_repo->storeLink();
		$contact_emails = $this->settings_repo->getSetting('contact_emails');
		$footer_scripts = $this->settings_repo->getSetting('footer_scripts');

		return View::make('admin.settings.index')
			->with('store_link', $store_link)
			->with('social_links', $social_links)
			->with('social_creds', $social_creds)
			->with('contact_emails', $contact_emails)
			->with('footer_scripts', $footer_scripts);
	}


	/**
	 * Update the settings
	 *
	 * @param  int  $id
	 */
	public function update()
	{
		$validation = Validator::make(Input::all(), Setting::$settings_required);
		if ( $validation->fails() ){
			return Redirect::back()
				->withErrors($validation->messages())
				->withInput();
		}
		$this->settings_factory->updateSettings(Input::all());
		return Redirect::back()
			->with('success', 'Settings successfully updated.');
	}


}
