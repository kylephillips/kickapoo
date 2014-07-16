<?php
class SessionController extends BaseController {

	/**
	* Admin Login Form
	*/
	public function getLogin()
	{
		return View::make('admin.login');
	}

	/**
	* Process the login form
	*/
	public function postLogin()
	{
		if ( Auth::attempt(['email'=>Input::get('email'), 'password'=>Input::get('password')]) ){
			return Redirect::back()
				->with('success', 'You are now logged in');
		}
		return Redirect::back()
			->withInput()
			->with('error', 'The email or password you entered is incorrect');
	}

	/**
	* Log the user out
	*/
	public function logout()
	{
		Auth::logout();
		return Redirect::route('login_form')
			->with('success', 'You are now logged out.');
	}

}