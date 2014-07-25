<?php
use Kickapoo\Repositories\SettingRepository;

class SettingController extends \BaseController {

	/**
	* Settings Repository
	*/
	protected $settings_repo;

	public function __construct(SettingRepository $settings_repo)
	{
		$this->beforeFilter('admin');
		$this->settings_repo = $settings_repo;
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function index()
	{
		$settings = $this->settings_repo->socialCreds();
		return View::make('admin.settings.index')
			->with('settings', $settings);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


}
