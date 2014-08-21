<?php namespace Kickapoo\Factories;

use \CustomField;

class CustomFieldFactory {

	/**
	* Create a new Custom Field
	*/
	public function createField($input)
	{
		dd($input);
	}

	/**
	* Delete a series of fields
	* @param eloquent object
	*/
	public function deleteFields($fields)
	{
		foreach($fields as $field)
		{
			$field = CustomField::findOrFail($field['id']);
			$field->delete();
		}
	}

}