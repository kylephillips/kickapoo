<?php namespace Kickapoo\Factories;

use \Input;
use \Upload;
use \Response;
use \Image;

class UploadFactory {

	/**
	* The original uploaded file object
	*/
	private $file;

	/**
	* The destination folder full path
	*/
	private $destination;

	/**
	* The file name
	*/
	private $filename;

	/**
	* The original file name
	*/
	private $original_name;

	/**
	* The new upload's ID
	*/
	private $upload_id;


	public function __construct($file, $destination_folder)
	{
		$this->file = $file;
		$this->destination = '/assets/uploads/' . $destination_folder . '/';
		$this->upload();
		return $this->filename;
	}


	/**
	* Upload a new file
	*/
	private function upload()
	{
		try {
			$this->setOriginalName();
			$this->setFilename();
			$this->createThumbnail();
			$this->createLargeThumbnail();
			$upload_success = $this->file->move( public_path() . $this->destination, $this->filename );
		} catch (\Exception $e){
			return false;
		}

		$this->createUpload();
	}


	/**
	* Create a thumbnail for the file
	*/
	private function createThumbnail()
	{
		$thumbnail_destination = public_path() . $this->destination . '_thumbs/';
		$thumb = Image::make($this->file)->crop(100,100)->save($thumbnail_destination . $this->filename, 80);
	}

	/**
	* Create large thumbnail for the file
	*/
	private function createLargeThumbnail()
	{
		$thumbnail_destination = public_path() . $this->destination . '_thumbs-large/';
		$thumb = Image::make($this->file)->fit(400,200)->save($thumbnail_destination . $this->filename, 80);
	}


	/**
	* Create an Upload Record
	*/
	private function createUpload()
	{
		$upload = new Upload;
		$upload->title = $this->original_name;
		$upload->file = $this->filename;
		$upload->folder = $this->destination;
		$upload->save();
		$this->upload_id = $upload->id;
	}


	/**
	* Set the file name
	*/
	private function setFilename()
	{
		$this->filename = time() . '_' . $this->file->getClientOriginalName();
	}

	/**
	* Get the file name
	*/
	public function getFilename()
	{
		return $this->filename;
	}


	/**
	* Set the original file name
	*/
	public function setOriginalName()
	{
		$this->original_name = $this->file->getClientOriginalName();
	}

	/**
	* Get the new upload ID
	*/
	public function getID()
	{
		return $this->upload_id;
	}

	/**
	* Get the destination folder
	*/
	public function getFolder()
	{
		return $this->destination;
	}

}