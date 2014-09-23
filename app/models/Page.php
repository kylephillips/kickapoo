<?php
class Page extends Eloquent {

	protected $table = 'pages';

	protected $fillable = [
		'title', 'slug', 'content', 'author', 'status', 'menu_order', 'template', 'seo_title', 'seo_description', 'show_in_menu','language'
	];

	/**
	* Get all the custom fields for this page
	*/
	public function customfields()
	{
		return $this->hasMany('CustomField');
	}

	/**
	* Get a specified custom field - for use in templates
	*/
	public function get_field($field, $pageid)
	{
		try {
			$field = CustomField::where('name',$field)->with('image')->where('page_id',$pageid)->first();
			if ( $field->field_type == 'image' ){
				return $field->image->folder . $field->image->file;
			}
			return $field->value;
		} catch (\Exception $e){
			return false;
		}
	}

	/**
	* Get translated pages
	*/
	public function translations()
	{
		return $this->belongsToMany('Page', 'page_translations', 'parent_page', 'translated_page');
	}

	/**
	* Translation of
	*/
	public function translation_of()
	{
		return $this->belongsToMany('Page', 'page_translations', 'translated_page', 'parent_page');
	}
	
}