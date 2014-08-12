<?php


use Kickapoo\Factories\ContactFormFactory;

class ContactFormController extends BaseController {

	/**
	* Contact Form Factory
	*/
	private $form_factory;

	public function __construct(ContactFormFactory $form_factory)
	{
		$this->form_factory = $form_factory;
	}

	/**
	* Process the contact form
	* @todo Fire email notification
	*/
	public function process()
	{
		$validation = Validator::make(Input::all(), ContactForm::$required);
		if ( $validation->fails() ){
			return Redirect::back()->withErrors($validation)->withInput();
		}
		$this->form_factory->store(Input::all());
		return Redirect::back()->with('success', 'Thank you for contacting us!');
	}


}