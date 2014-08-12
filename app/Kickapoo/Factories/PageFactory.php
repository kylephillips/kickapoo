<?php namespace Kickapoo\Factories;

use \Page;

class PageFactory {

	public function updatePage($id, $input)
	{
		$page = Page::findOrFail($id);
		$page->title = $input['title'];
		$page->slug = $input['slug'];
		$page->status = $input['status'];
		$page->content = $input['content'];
		$page->template = $input['template'];
		$page->seo_title = ( isset($input['seo_title']) ) ? $input['seo_title'] : null;
		$page->seo_description = ( isset($input['seo_description']) ) ? $input['seo_description'] : null;
		$page->save();
		return $page;
	}

}