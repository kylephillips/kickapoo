<?php namespace Kickapoo\Factories;

use \CustomField;

class CustomFieldFactory {

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