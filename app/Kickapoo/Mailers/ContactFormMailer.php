<?php namespace Kickapoo\Mailers;

use Kickapoo\Repositories\SettingRepository;
use \Mail;
use \URL;

class ContactFormMailer {

	/**
	* Settings Repository
	*/
	private $settings_repo;


	public function __construct(SettingRepository $settings_repo)
	{
		$this->settings_repo = $settings_repo;
	}

	/**
	* Send an admin notification that a contact form has been submitted
	*/
	public function adminNotification($data)
	{
		$opt_in = ( isset($data['email_opt_in']) ) ? 'Yes' : 'No';
		$mail_data = [
			'name' => $data['name'],
			'email' => $data['email'],
			'user_message' => $data['message'],
			'logo' => URL::asset('assets/images/kickapoo-email-logo.png'),
			'opt_in' => $opt_in
		];
		$emails = $this->settings_repo->getSetting('contact_emails');
		if ( $emails ){
			$to = explode(',', $emails);
			Mail::send('emails.contact-notification', $mail_data, function($message) use ($to) {
				$message->from('donotreply@drinkkickapoo.com', 'Kickapoo Website');
				$message->subject('Contact form submitted on Kickapoo Website');
				$message->to($to);
			});
		}
	}

}