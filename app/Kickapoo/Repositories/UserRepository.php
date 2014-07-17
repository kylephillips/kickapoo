<?php namespace Kickapoo\Repositories;

use \User;
use \Group;

class UserRepository {

	/**
	* Get all users
	*/
	public function getAll()
	{
		return User::get();
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

}