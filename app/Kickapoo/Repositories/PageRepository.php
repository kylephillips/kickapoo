<?php namespace Kickapoo\Repositories;

use \Page;

class PageRepository {

	/**
	* Get Page for navigation
	*/
	public function getNavigation()
	{
		return Page::where('status', 'publish')->where('menu_order', '!=', 0)->orderBy('menu_order')->get();
	}

	/**
	* Get All Pages
	*/
	public function getAllPages()
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