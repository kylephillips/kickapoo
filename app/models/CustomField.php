<?php
class CustomField extends Eloquent {

	protected $table = 'customfields';

	protected $fillable = [
		'key', 'value', 'field_type', 'page_id'
	];

	public function page()
	{
		return $this->belongsTo('Page');
	}

}