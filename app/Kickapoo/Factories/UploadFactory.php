<?php namespace Kickapoo\Factories;

use \Input;
use \Upload;
use \Response;
use \Image;

class UploadFactory {

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
	* Upload a page image
	* @return string - path to new image
	*/
	public function uploadPageImage($file)
	{
		$this->setDestination('/assets/uploads/page_images/');
		return $this->uploadFile($file);
	}


	/**
	* Upload a new file
	*/
	private function uploadFile($file)
	{
		try {
			$this->setOriginalName($file->getClientOriginalName());
			$this->setFilename(time() . '_' . $file->getClientOriginalName());
			$full_path = public_path() . $this->destination;
			$this->createThumbnail($file);
			$upload_success = $file->move($full_path, $this->filename);
		} catch (\Exception $e){
			return false;
		}

		$this->createUpload();
		return $this->destination . $this->filename;
	}


	/**
	* Create a thumbnail for the file
	*/
	private function createThumbnail($file)
	{
		$thumbnail_destination = public_path() . '/assets/uploads/page_images/_thumbs/';
		$thumb = Image::make($file)->crop(100,100)->save($thumbnail_destination . $this->filename, 80);
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
	private function setFilename($filename)
	{
		$this->filename = $filename;
	}


	/**
	* Set the original file name
	*/
	public function setOriginalName($filename)
	{
		$this->original_name = $filename;
	}

}