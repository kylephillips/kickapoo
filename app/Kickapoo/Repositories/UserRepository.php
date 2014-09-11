<?php namespace Kickapoo\Repositories;

use \User;
use \Group;
use \Banned;

class UserRepository {

	/**
	* Get all users
	*/
	public function getAll()
	{
		return User::get();
	}

	/**
	* Get Specific User
	*/
	public function getUser($id)
	{
		return User::findOrFail($id);
	}

	/**
	* Get all groups and return as array
	*/
	public function groupsArray()
	{	
		$groups = Group::get();
		foreach ( $groups as $group )
		{
			$all_groups[$group->id] = $group->title;
		}
		return $all_groups;
	}

	/**
	* Get all Banned
	*/
	public function getBanned()
	{
		return Banned::get();
	}

	/**
	* Get Admins
	*/
	public function getAdmins()
	{
		return User::where('group_id',1)->orWhere('group_id',2)->get();
	}

}