<?php
class Group extends Eloquent {

	protected $table = 'groups';

	protected $fillable = ['title', 'slug'];

	public function users()
	{
		return $this->hasMany('User');
	}

}