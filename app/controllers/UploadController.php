<?php
use Kickapoo\Factories\UploadFactory;

class UploadController extends BaseController {

	/**
	* Upload Factory
	*/
	protected $upload_factory;


	public function __construct(UploadFactory $upload_factory)
	{
		$this->upload_factory = $upload_factory;
	}


	/**
	* Upload a file through editor
	*/
	public function editorUpload()
	{
		$upload = $this->upload_factory->uploadImage(Input::file('file'));
		if ( $upload ){
			return Response::json(['filelink' => $upload]);
		} else {
			return Response::json(['error'=>'There was an error uploading this file.']);
		}
	}


	/**
	* Display the Media Library
	*/
	public function mediaLibrary()
	{
		if ( Request::ajax() ){
			return Response::json(['status'=>'success']);
		}
	}

}