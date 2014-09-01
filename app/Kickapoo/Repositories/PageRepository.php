<?php namespace Kickapoo\Repositories;

use \Page;
use \LaravelLocalization;

class PageRepository {

	/**
	* Get Page for navigation
	*/
	public function getNavigation()
	{
		$lang = LaravelLocalization::getCurrentLocale();
		return Page::where('status', 'publish')->where('show_in_menu', '=', 1)->where('language',$lang)->orderBy('menu_order')->get();
	}

	/**
	* Get All Pages
	*/
	public function getAllPages()
	{
		$lang = LaravelLocalization::getCurrentLocale();
		return Page::where('language',$lang)->orderBy('menu_order')->get();
	}


	/**
	* Get a Single Page from a slug
	*/
	public function getPage($slug, $lang = 'en')
	{
		$page = Page::where('slug', $slug)->with('customfields','translations','translation_of')->firstOrFail();
		if ( $lang == 'en' ) return $page;
		
		// Return translated page if not english
		foreach($page->translations as $translation)
		{
			if ( $translation->language == $lang )
			return $translation;
		}
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