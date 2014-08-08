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

	/**
	* Get a Single Page from a slug
	*/
	public function getPage($slug)
	{
		return Page::where('slug', $slug)->firstOrFail();
	}
	

}