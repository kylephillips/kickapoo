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

		$mail_data = [
			'name' => Input::get('name'),
			'email' => Input::get('email'),
			'user_message' => Input::get('message')
		];
		Mail::send('emails.contact-notification', $mail_data, function($message){
			$message->from('donotreply@drinkkickapoo.com', 'Kickapoo Website');
			$message->subject('Contact form submitted on Kickapoo Website');
			$message->to(['kyle@object9.com', 'kylephillipsdesign@gmail.com']);
		});

		return Redirect::back()->with('success', 'Thank you for contacting us!');
	}


}