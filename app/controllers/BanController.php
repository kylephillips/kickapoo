<?php

use \Kickapoo\Repositories\UserRepository;

class BanController extends \BaseController {

	/**
	* User Repo
	*/
	protected $user_repo;

	public function __construct(UserRepository $user_repo)
	{
		$this->user_repo = $user_repo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$banned_users = $this->user_repo->getBanned();
		return View::make('admin.banned.index')
			->with('banned_users', $banned_users);
	}


	/**
	 * Ban a user.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ( Request::ajax() ){
			Banned::create([
				'screen_name' => Input::get('id'),
				'type' => Input::get('type')
			]);
			return Response::json(['status'=>'success']);
		}
	}

	/**
	* Unban a user.
	*/
	public function unban()
	{
		$banned = Banned::where('id', Input::get('id'));
		$banned->delete();
		return Response::json(['status'=>'success']);
	}



}
