<?php
class Language extends Eloquent {

	protected $table = 'languages';
	protected $fillable = ['title', 'slug', 'flag'];

}