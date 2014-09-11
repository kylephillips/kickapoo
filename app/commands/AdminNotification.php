<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Kickapoo\Mailers\UnmoderatedPostsNotification;

class AdminNotification extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'kickapoo:adminnotification';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send admin notification emails.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 */
	public function fire()
	{
		$notifications = new Kickapoo\Mailers\UnmoderatedPostsNotification;
	}

}
