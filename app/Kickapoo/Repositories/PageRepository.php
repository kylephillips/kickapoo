<?php namespace Kickapoo\Repositories;

use \Page;

class PageRepository {

	/**
	* Get Page for navigation
	*/
	public function getNavigation()
	{
		return Page::where('status', 'publish')->where('show_in_menu', '=', 1)->orderBy('menu_order')->get();
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
		return Page::where('slug', $slug)->with('customfields')->firstOrFail();
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
				$name = str_replace('_', ' ', $file);
				$templates[$file] = ucwords($name);
			}
		}
		return $templates;
	}
	

}