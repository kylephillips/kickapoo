<?php namespace Kickapoo\Repositories;

use \ContactForm;

class ContactFormRepository {

	public function getAll()
	{
		return ContactForm::paginate(20);
	}

	public function get($id)
	{
		return ContactForm::findOrFail($id);
	}

}