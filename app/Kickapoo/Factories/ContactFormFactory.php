<?php namespace Kickapoo\Factories;

use \ContactForm;

class ContactFormFactory {

	/**
	* Store a new form entry
	*/
	public function store($input)
	{
		$opt_in = ( isset($input['email_opt_in']) ) ? 1 : 0;
		ContactForm::create([
			'name' => $input['name'],
			'email' => $input['email'],
			'message' => $input['message'],
			'email_opt_in' => $opt_in
		]);
	}

}