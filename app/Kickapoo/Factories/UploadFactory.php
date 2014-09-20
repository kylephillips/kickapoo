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
	* The destination folder
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
	* Upload an image
	* @return string - path to new image
	*/
	public function uploadImage($file)
	{
		$this->file = $file;
		$this->setDestination('/assets/uploads/page_images/');
		return $this->upload();
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
		return $this->destination . $this->filename;
	}


	/**
	* Create a thumbnail for the file
	*/
	private function createThumbnail()
	{
		$thumbnail_destination = public_path() . '/assets/uploads/page_images/_thumbs/';
		$thumb = Image::make($this->file)->crop(100,100)->save($thumbnail_destination . $this->filename, 80);
	}

	/**
	* Create large thumbnail for the file
	*/
	private function createLargeThumbnail()
	{
		$thumbnail_destination = public_path() . '/assets/uploads/page_images/_thumbs-large/';
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
	}


	/**
	* Set the destination folder
	*/
	private function setDestination($destination)
	{
		$this->destination = $destination;
	}


	/**
	* Set the file name
	*/
	private function setFilename()
	{
		$this->filename = time() . '_' . $this->file->getClientOriginalName();
	}


	/**
	* Set the original file name
	*/
	public function setOriginalName()
	{
		$this->original_name = $this->file->getClientOriginalName();
	}

}