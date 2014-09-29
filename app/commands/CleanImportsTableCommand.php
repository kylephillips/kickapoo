<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Kickapoo\Repositories\PostRepository;

class CleanImportsTableCommand extends Command {

	/**
	* Post Repository
	*/
	private $post_repo;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'kickapoo:cleanimports';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Remove import logs older than 2 days.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(PostRepository $post_repo)
	{
		parent::__construct();
		$this->post_repo = $post_repo;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->post_repo->cleanImportsTable();
	}

}
