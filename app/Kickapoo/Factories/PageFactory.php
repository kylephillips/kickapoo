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
		$page->save();
		return $page;
	}

}