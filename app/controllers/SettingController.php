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
		$settings = $this->settings_repo->socialCreds();
		$links = $this->settings_repo->links();
		return View::make('admin.settings.index')
			->with('links', $links)
			->with('settings', $settings);
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
