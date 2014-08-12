<?php namespace Kickapoo\Repositories;

use \ContactForm;

class ContactFormRepository {

	public function getAll()
	{
		return ContactForm::paginate(20);
	}

}