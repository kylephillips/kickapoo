<?php namespace Kickapoo\Mailers;

use \Mail;
use \URL;

class NewUserMailer {

	/**
	* Data used in email
	*/
	private $data;


	public function __construct($data)
	{
		$this->data = $data;
		$this->notify_user();
	}

	/**
	* Send the new user a welcome email
	*/
	public function notify_user()
	{
		$mail_data = [
			'name' => $this->data['firstname'] . ' ' . $this->data['lastname'],
			'email' => $this->data['email'],
			'logo' => URL::asset('assets/images/kickapoo-email-logo.png')
		];
		$to = $this->data['email'];
		Mail::send('emails.new-user', $mail_data, function($message) use ($to) {
			$message->from('donotreply@drinkkickapoo.com', 'Kickapoo Website');
			$message->subject('Welcome to the Kickapoo Website');
			$message->to($to);
		});
	}

}