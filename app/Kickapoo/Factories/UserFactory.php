<?php namespace Kickapoo\Factories;

use Kickapoo\Repositories\UserRepository;
use \User;
use \Input;
use \Hash;

class UserFactory {

	/**
	* Create a new user
	*/
	public function createUser($input)
	{
		User::create([
			'first_name' => Input::get('firstname'),
			'last_name' => Input::get('lastname'),
			'email' => Input::get('email'),
			'group_id' => Input::get('group'),
			'password' => Hash::make(Input::get('password'))
		]);
	}

	/**
	* Update a current user
	*/
	public function updateUser($id, $input)
	{
		//dd($input);
		$user = User::findOrFail($id);
		if ( $input['firstname'] ) $user->first_name = $input['firstname'];
		if ( $input['lastname'] ) $user->last_name = $input['lastname'];
		if ( $input['email'] ) $user->email = $input['email'];
		if ( $input['group'] ) $user->group_id = $input['group'];
		if ( $input['password'] ) $user->password = Hash::make($input['password']);
		if ( isset($input['notify_unmoderated']) ) $user->notify_unmoderated = $input['notify_unmoderated'];
		if ( $input['notify_unmoderated_count'] ) $user->notify_unmoderated_count = $input['notify_unmoderated_count'];
		$user->save();
	}

}