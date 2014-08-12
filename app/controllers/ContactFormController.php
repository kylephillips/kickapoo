<?php

use Kickapoo\Factories\ContactFormFactory;
use Kickapoo\Repositories\ContactFormRepository;
use Kickapoo\Mailers\ContactFormMailer;

class ContactFormController extends BaseController {


	/**
	* Contact Form Factory
	*/
	private $form_factory;

	/**
	* Contact Form Repository
	*/
	private $form_repo;

	/**
	* Mailer
	*/
	private $form_mailer;


	public function __construct(ContactFormFactory $form_factory, ContactFormMailer $form_mailer, ContactFormRepository $form_repo)
	{
		$this->form_factory = $form_factory;
		$this->form_repo = $form_repo;
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

	/**
	* View Form Entries
	*/
	public function index()
	{
		$entries = $this->form_repo->getAll();
		return View::make('admin.forms.index')
			->with('entries', $entries);
	}


}