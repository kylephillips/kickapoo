<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Kickapoo\Repositories\PostRepository;

class CleanOldPostsCommand extends Command {

	/**
	* Post Repository
	*/
	private $post_repo;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'kickapoo:cleanposts';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Remove unmoderated posts from database that are older than a month.';

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
		$this->post_repo->cleanOldPosts();
	}

}
