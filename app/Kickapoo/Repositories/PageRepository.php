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
		return Page::orderBy('menu_order')->get();
	}

	/**
	* Get a Single Page from a slug
	*/
	public function getPage($slug)
	{
		return Page::where('slug', $slug)->firstOrFail();
	}

	/**
	* Get an array of all page templates
	*/
	public function getPageTemplates()
	{
		$path = app_path() . '/views/pages';
		$files = scandir($path);
		foreach($files as $file)
		{
			if ( strlen($file) > 2 ) 
			{
				$file = str_replace('.blade.php', '', $file);
				$templates[$file] = ucfirst($file);
			}
		}
		return $templates;
	}
	

}