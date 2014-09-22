<?php namespace Kickapoo\Mailers;

use Kickapoo\Repositories\UserRepository;
use \Mail;
use \URL;

class NewUserAdminNotification {

	/**
	* Data used in email
	*/
	private $data;


	public function __construct($data)
	{
		$this->data = $data;
		$this->notify_admins();
	}

	/**
	* Send the new user a welcome email
	*/
	public function notify_admins()
	{
		$mail_data = [
			'name' => $this->data['firstname'] . ' ' . $this->data['lastname'],
			'email' => $this->data['email'],
			'logo' => URL::asset('assets/images/kickapoo-email-logo.png')
		];
		
		$user_repo = new UserRepository;
		$admins = $user_repo->getAdminEmails();
		Mail::send('emails.new-user-admin-notification', $mail_data, function($message) use ($admins) {
			$message->from('donotreply@drinkkickapoo.com', 'Kickapoo Website');
			$message->subject('Welcome to the Kickapoo Website');
			$message->to($admins);
		});
	}

}