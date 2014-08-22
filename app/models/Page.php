<?php
class Page extends Eloquent {

	protected $table = 'pages';

	protected $fillable = [
		'title', 'slug', 'content', 'author', 'status', 'menu_order', 'template', 'seo_title', 'seo_description', 'show_in_menu'
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
			$field = CustomField::where('name',$field)->where('page_id',$pageid)->first();
			return $field->value;
		} catch (\Exception $e){
			return false;
		}
	}
	
}