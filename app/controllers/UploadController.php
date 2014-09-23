<?php
use Kickapoo\Factories\UploadFactory;
use Kickapoo\Repositories\UploadRepository;

class UploadController extends BaseController {

	/**
	* Upload Factory
	*/
	protected $upload_factory;

	/**
	* Upload Repository
	*/
	protected $upload_repo;


	public function __construct(UploadFactory $upload_factory, UploadRepository $upload_repo)
	{
		$this->upload_factory = $upload_factory;
		$this->upload_repo = $upload_repo;
	}


	/**
	* Upload a file through editor
	*/
	public function editorUpload()
	{
		$upload = $this->upload_factory->uploadImage(Input::file('file'), 'page_images');
		if ( $upload ){
			return Response::json(['filelink' => $upload]);
		} else {
			return Response::json(['error'=>'There was an error uploading this file.']);
		}
	}

	/**
	* Library Modal Upload (dropzone)
	*/
	public function libraryUpload()
	{
		if ( Request::ajax() ){
			$upload = $this->upload_factory->uploadImage(Input::file('file'), Input::get('folder'));
			if ( $upload ){
				return Response::json(['status'=>'success', 'file' => $upload, 'folder' => Input::get('folder')]);
			} else {
				return Response::json(['status'=>'error', 'error'=>'There was an error uploading this file.']);
			}
		}
	}


	/**
	* Display the Media Library
	*/
	public function mediaLibrary()
	{
		if ( Request::ajax() ){
			$media = $this->upload_repo->getDirectory(Input::get('directory'));
			$folders = $this->upload_repo->getDirectoriesArray();
			return Response::json([
				'status'=>'success', 
				'folders'=>$folders, 
				'media'=>$media
			]);
		}
	}

}