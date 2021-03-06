<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';


	/**
	* Mass Assignable Vars
	*/
	protected $fillable = ['email', 'password', 'group_id', 'first_name', 'last_name', 'notify_unmoderated', 'notify_unmoderated_count'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	/**
	* Methods required for remember me functionality
	*/ 
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	public function group()
	{
		return $this->belongsTo('Group');
	}

	/**
	* Post Relationship
	*/
	public function post()
	{
		return $this->hasMany('Post');
	}

	public static $required = [
		'firstname' => 'required',
		'lastname' => 'required',
		'email' => 'required|unique:users,email',
		'password' => 'required|min:6|confirmed',
		'password_confirmation' => 'required'
	];

}
