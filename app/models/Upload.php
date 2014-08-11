<?php
class Upload extends Eloquent {

	protected $table = 'uploads';

	protected $fillable = [
		'file', 'folder', 'title', 'alt', 'caption'
	];

}