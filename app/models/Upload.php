<?php
class Upload extends Eloquent {

	protected $table = 'uploads';

	protected $fillable = [
		'file', 'folder', 'title', 'alt', 'caption'
	];

	public function customfield()
	{
		return $this->belongsTo('CustomField');
	}

}