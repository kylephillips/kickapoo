<?php namespace Kickapoo\SocialImport;
use Kickapoo\Factories\FBPostFactory;
use \FBPost;
use \Trash;
use \Banned;

class FacebookImport {


	/**
	* The Feed to Import
	* @var array
	*/
	private $feed;


	/**
	* Import Count
	* @var int
	*/
	private $import_count;


	public function __construct($feed)
	{
		$this->feed = $feed;
		$this->import_count = 0;
		$this->doImport();
	}


	/**
	* Import the Posts
	*/
	private function doImport()
	{
		if ( $this->feed ) :
			foreach ( $this->feed as $key=>$item )
			{
				if ( $this->validates($item) )
				{
					$gram = new FBPostFactory;
					$gram->createPost($item);
					$this->import_count++;

				} elseif ( count($this->feed) == 1 ){
					if ( $this->exists($item['id']) ) throw new \Kickapoo\Exceptions\PostExistsException;
					if ( $this->trashed($item['id']) ) throw new \Kickapoo\Exceptions\PostTrashedException;
				}
			}
		endif;
	}


	/**
	* Validate the Item
	*/
	private function validates($item)
	{
		if ( $this->exists($item['id']) ) return false;
		if ( $this->trashed($item['id']) ) return false;
		return true;
	}


	/**
	* Check if already imported
	* @param int
	*/
	private function exists($id)
	{
		return ( FBPost::where('facebook_id', $id)->count() ) ? true : false;
	}


	/**
	* Check if trashed
	* @param int
	*/
	private function trashed($id)
	{
		return ( Trash::where('facebook_id', $id)->count() ) ? true : false;
	}


	/**
	* Get the Import Count
	* @return int
	*/
	public function getCount()
	{
		return $this->import_count;
	}

}