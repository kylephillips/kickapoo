<?php
class CustomField extends Eloquent {

	protected $table = 'customfields';

	protected $fillable = [
		'name', 'key', 'value', 'field_type', 'page_id', 'upload_id'
	];

	public static $required = [
		'name' => 'required|unique:customfields,name',
		'type' => 'required',
		'page_id' => 'required|exists:pages,id'
	];

	public function page()
	{
		return $this->belongsTo('Page');
	}

	public function image()
	{
		return $this->hasOne('Upload', 'id', 'upload_id');
	}

}