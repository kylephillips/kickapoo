<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Kickapoo\Factories\TrashFactory;

class EmptyTrashCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'kickapoo:emptytrash';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Empty all items in the trash.';

	/**
	* Trash Factory
	*/
	protected $trash_factory;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(TrashFactory $trash_factory)
	{
		parent::__construct();
		$this->trash_factory = $trash_factory;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->trash_factory->emptyTrash();
	}

}
