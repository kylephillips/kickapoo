<?php
use Kickapoo\Repositories\UserRepository;

class UserController extends \BaseController {

	/**
	* User Repository
	*/
	protected $user_repo;


	public function __construct(UserRepository $user_repo)
	{
		$this->user_repo = $user_repo;
	}

	/**
	 * Display all users.
	 *
	 * @return View
	 */
	public function index()
	{
		$users = $this->user_repo->getAll();
		return View::make('admin.users.user')
			->with('users', $users);
	}


	/**
	 * Show the form for adding a new user
	 *
	 * @return Response
	 */
	public function create()
	{
		$groups = $this->user_repo->groupsArray();
		return View::make('admin.users.create')
			->with('groups', $groups);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
