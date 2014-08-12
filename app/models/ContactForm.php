<?php
class ContactForm extends Eloquent {

	protected $table = 'forms';

	protected $fillable = [
		'name', 'email', 'message', 'share'
	];

	public static $required = [
		'name' => 'required',
		'email' => 'required|email',
		'message' => 'required',
		'user-captcha' => 'required|captcha'
	];

}