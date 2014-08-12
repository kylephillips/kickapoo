<?php namespace Kickapoo\Factories;

use \ContactForm;

class ContactFormFactory {

	/**
	* Store a new form entry
	*/
	public function store($input)
	{
		ContactForm::create([
			'name' => $input['name'],
			'email' => $input['email'],
			'message' => $input['message'] 
		]);
	}

}