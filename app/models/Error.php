<?php
class Error extends Eloquent {

	protected $table = 'errors';
	public $timestamps = false;
	protected $fillable = ['time', 'message'];

}