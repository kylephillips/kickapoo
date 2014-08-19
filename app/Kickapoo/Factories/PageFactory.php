<?php namespace Kickapoo\Factories;

use \Page;
use \CustomField;
use \Str;
use \Image;

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
		if( isset($input['newcustomfield']) ) $this->addCustomFields($input['newcustomfield']);
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
	public function addCustomFields($fields)
	{
		foreach($fields as $field){
			$value = ( $field['fieldtype'] == 'image' ) ? $this->attachImage($field['fieldvalue']) : $field['fieldvalue'];
			CustomField::create([
				'name' => $field['fieldname'],
				'key' => Str::slug($field['fieldname']),
				'field_type' => $field['fieldtype'],
				'page_id' => $field['page_id'],
				'value' => $value
			]);
		}
	}

	/**
	* Upload an image for use in custom field
	* @return string
	*/
	private function attachImage($file)
	{
		$destination = public_path() . '/assets/uploads/page_images/';
		$thumbnail_destination = public_path() . '/assets/uploads/page_images/_thumbs/';
		$filename = time() . '_' . $file->getClientOriginalName();
		try {
			$thumb = Image::make($file)->crop(100,100)->save($thumbnail_destination . $filename, 80);
			$uploadSuccess = $file->move($destination, $filename);
			return $filename;
		} catch (\Exception $e) {
			return null;
		}
	}

}