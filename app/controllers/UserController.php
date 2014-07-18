<?php
use Kickapoo\Repositories\UserRepository;
use Kickapoo\Factories\UserFactory;

class UserController extends \BaseController {

	/**
	* User Repository
	*/
	protected $user_repo;


	/**
	* User Factory
	*/
	protected $user_factory;


	public function __construct(UserRepository $user_repo, UserFactory $user_factory)
	{
		$this->beforeFilter('admin', ['only'=>['index','destroy','create','store']]);
		$this->user_repo = $user_repo;
		$this->user_factory = $user_factory;
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
	 * @return View
	 */
	public function create()
	{
		$groups = $this->user_repo->groupsArray();
		return View::make('admin.users.create')
			->with('groups', $groups);
	}


	/**
	 * Store a new user
	 *
	 */
	public function store()
	{
		$validation = Validator::make(Input::all(), User::$required);
		if ( $validation->fails() ){
			return Redirect::back()
				->withErrors($validation)->withInput();
		} else {
			$this->user_factory->createUser(Input::all());
			return Redirect::route('admin.user.index')
				->with('success', 'User successfully added! Joy!');
		}
	}


	/**
	 * Show the form for editing user
	 *
	 * @param  int  $id
	 */
	public function edit($id)
	{
		if ( (Auth::user()->id != $id) && (Auth::user()->group_id != 1) ) return Redirect::route('admin_index');

		$groups = $this->user_repo->groupsArray();
		$user = $this->user_repo->getUser($id);

		return View::make('admin.users.edit')
			->with('groups', $groups)
			->with('user', $user);
	}


	/**
	 * Update the User
	 *
	 * @param  int  $id
	 */
	public function update($id)
	{
		$user_repo = new UserRepository;
		$user = $user_repo->getUser($id);

		$validation = Validator::make(Input::all(), [
			'firstname' => 'required',
			'lastname' => 'required',
			'email' => 'required'
		]);
		$validation->sometimes('email', 'unique:users,email', function($input) use ($user) {
			return $input->email !== $user->email;
		});
		$validation->sometimes('password', ['min:6', 'confirmed'], function($input){
			return $input->password !== '';
		});

		if ( $validation->fails() ){
			return Redirect::back()->withErrors($validation)->withInput();	
		}
		
		$this->user_factory->updateUser($id, $input = Input::all());
		return Redirect::route('admin.user.index')
			->with('success', 'User successfully updated!');
	}


	/**
	 * Remove a User.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		$user = User::find($id);
		$user->delete();
	}


}
