<?php

use Kickapoo\Factories\ContactFormFactory;
use Kickapoo\Mailers\ContactFormMailer;

class ContactFormController extends BaseController {


	/**
	* Contact Form Factory
	*/
	private $form_factory;

	/**
	* Mailer
	*/
	private $form_mailer;


	public function __construct(ContactFormFactory $form_factory, ContactFormMailer $form_mailer)
	{
		$this->form_factory = $form_factory;
		$this->form_mailer = $form_mailer;
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
		$this->form_mailer->adminNotification(Input::all());
		return Redirect::back()->with('success', 'Thank you for contacting us!');
	}


}