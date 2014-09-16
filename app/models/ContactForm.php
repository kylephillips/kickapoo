<?php
class ContactForm extends Eloquent {

	protected $table = 'forms';

	protected $fillable = [
		'name', 'email', 'message', 'share', 'email_opt_in'
	];

	public static $required = [
		'name' => 'required',
		'email' => 'required|email',
		'message' => 'required',
		'user-captcha' => 'required|captcha'
	];

}