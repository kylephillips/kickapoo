<?php namespace Kickapoo\Mailers;

use Kickapoo\Repositories\UserRepository;
use Kickapoo\Repositories\PostRepository;
use \Mail;
use \URL;

class UnmoderatedPostsNotification {

	/**
	* User Repository
	*/
	private $user_repo;


	/**
	* Users
	*/
	private $users;


	/**
	* Unmoderated Post Count
	*/
	private $unmoderated_count;


	public function __construct()
	{
		$this->getAdmins();
		$this->setUnmoderatedCount();
		$this->processUsers();
	}


	/**
	* Get all the site admins/editors
	*/ 
	private function getAdmins()
	{
		$users = new UserRepository;
		$this->users = $users->getAdmins();
	}


	/**
	* Set the number of unmoderated posts
	*/
	private function setUnmoderatedCount()
	{
		$count = new PostRepository;
		$this->unmoderated_count = $count->getPendingCount();
	}


	/**
	* Process Users for Unmoderated Notification
	*/
	private function processUsers()
	{
		foreach ( $this->users as $user ){
			if ( ($user->notify_unmoderated == 1)  && ( $user->notify_unmoderated_count <= $this->unmoderated_count ) ){
				$this->sendNotification($user);
			}
		}
	}


	/**
	* Send Notification Email
	*/
	private function sendNotification($user)
	{
		$mail_data = [
			'count' => $this->unmoderated_count,
			'login_link' => URL::route('admin_index'),
			'logo' => URL::asset('assets/images/kickapoo-email-logo.png')
		];
		$to = $user->email;
		Mail::send('emails.unmoderated-count-notification', $mail_data, function($message) use ($to) {
			$message->from('donotreply@drinkkickapoo.com', 'Kickapoo Website');
			$message->subject('There are posts waiting to be moderated');
			$message->to($to);
		});
	}

}