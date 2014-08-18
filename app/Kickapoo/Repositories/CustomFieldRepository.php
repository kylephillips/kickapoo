<?php namespace Kickapoo\Repositories;

use \CustomField;

class CustomFieldRepository {

	/**
	* Get a single field by id
	*/
	public function getField($id)
	{
		return CustomField::findOrFail($id);
	}

}