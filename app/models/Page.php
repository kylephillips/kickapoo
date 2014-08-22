<?php
class Page extends Eloquent {

	protected $table = 'pages';

	protected $fillable = [
		'title', 'slug', 'content', 'author', 'status', 'menu_order', 'template', 'seo_title', 'seo_description', 'show_in_menu'
	];

	public function customfields()
	{
		return $this->hasMany('CustomField');
	}
	
}