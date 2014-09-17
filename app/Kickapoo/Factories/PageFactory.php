<?php namespace Kickapoo\Factories;

use \Page;
use \CustomField;
use \Str;
use \Image;
use \Auth;
use Kickapoo\Factories\UploadFactory;

class PageFactory {

	/**
	* Add a new page
	*/
	public function createPage($input)
	{
		$slug = ( $input['slug'] ) ? Str::slug($input['slug']) : Str::slug($input['title']);
		$seo_title = ( $input['seo_title'] ) ? $input['seo_title'] : null;
		$seo_description = ( $input['seo_description'] ) ? $input['seo_description'] : null;
		$language = ( isset($input['language']) ) ? $input['language'] : 'en';

		$menu_order = Page::where('language', $language)->orderBy('menu_order', 'DESC')->first();
		$menu_order = ( $menu_order ) ? $menu_order->menu_order + 1 : 0;

		$page = Page::create([
			'title' => $input['title'],
			'slug' => $slug,
			'status' => $input['status'],
			'content' => $input['content'],
			'template' => $input['template'],
			'seo_title' => $seo_title,
			'seo_description' => $seo_description,
			'author' => Auth::user()->id,
			'menu_order' => $menu_order,
			'language' => $language
		]);
		if ( isset($input['newcustomfield']) ) $this->addCustomFields($input['newcustomfield'], $page->id);
		if ( isset($input['language']) ) $this->addTranslation($input['parent_page'], $page->id);
		return $page;
	}

	/**
	* Update an existing page
	*/
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
		if( isset($input['newcustomfield']) ) $this->addCustomFields($input['newcustomfield'], $page->id);
		if( isset($input['customfield']) ) $this->updateCustomFields($input['customfield']);
		return $page;
	}

	
	/**
	* Update existing custom fields
	*/
	public function updateCustomFields($fields)
	{
		foreach($fields as $field){
			$cfield = CustomField::findOrFail($field['id']);
			$cfield->name = $field['name'];
			$cfield->key = Str::slug($field['name']);
			
			if ( ($field['field_type'] == 'image') && (isset($field['value']) ) ){
				$cfield->value = $this->attachImage($field['value']);
			}
			elseif ( $field['field_type'] != 'image' ){
				$cfield->value = $field['value'];
			}

			$cfield->save();
		}
	}


	/**
	* Add new custom fields
	* @param array
	*/
	public function addCustomFields($fields, $page_id)
	{
		foreach($fields as $field){
			$value = ( $field['fieldtype'] == 'image' ) ? $this->attachImage($field['fieldvalue']) : $field['fieldvalue'];
			CustomField::create([
				'name' => $field['fieldname'],
				'key' => Str::slug($field['fieldname']),
				'field_type' => $field['fieldtype'],
				'page_id' => $page_id,
				'value' => $value
			]);
		}
	}


	/**
	* Upload an Image
	*/
	private function attachImage($file)
	{
		$upload = new UploadFactory;
		$upload = $upload->uploadImage($file);
		return basename($upload);
	}


	/**
	* Update the order of pages
	*/
	public function updateOrder($pages)
	{
		foreach($pages as $key=>$page)
		{
			$page = Page::findOrFail($page);
			$page->menu_order = $key;
			$page->save();
		}
	}

	/**
	* Add Translation Record
	*/
	private function addTranslation($parent_page, $translated_page)
	{
		$parent = Page::find($parent_page);
		$parent->translations()->attach($translated_page);
	}

}