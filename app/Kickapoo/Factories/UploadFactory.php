<?php namespace Kickapoo\Factories;

use \Input;
use \Upload;
use \Response;

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
	public function uploadFile($file)
	{
		try {
			$this->setFilename(time() . '_' . $file->getClientOriginalName());
			$full_path = public_path() . $this->destination;
			$upload_success = $file->move($full_path, $this->filename);
		} catch (\Exception $e){
			return false;
		}

		$this->createUpload();
		return $this->destination . $this->filename;
	}


	/**
	* Create an Upload Record
	*/
	private function createUpload()
	{
		$upload = new Upload;
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

}