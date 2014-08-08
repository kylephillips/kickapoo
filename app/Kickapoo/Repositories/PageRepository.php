<?php namespace Kickapoo\Repositories;

use \Page;

class PageRepository {

	/**
	* Get Page for navigation
	*/
	public function getNavigation()
	{
		return Page::where('status', 'publish')->orderBy('menu_order')->get();
	}

}