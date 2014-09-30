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


	public function __construct(UploadRepository $upload_repo)
	{
		$this->upload_repo = $upload_repo;
	}


	/**
	* Upload a file through editor
	* @todo Create method in upload factory to return full path of image, return path
	*/
	public function editorUpload()
	{
		$file = Input::file('file');
		$upload = new UploadFactory($file, 'page_images');
		if ( $upload ){
			return Response::json(['filelink' => $upload->getFolder() . $upload->getFilename()]);
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
			
			$upload = new UploadFactory(Input::file('file'), Input::get('folder'));
			
			if ( $upload ){
				return Response::json([
					'status'=>'success', 
					'upload_id' => $upload->getID(), 
					'file' => $upload->getFilename(), 
					'folder' => $upload->getFolder()
				]);
			} else {
				return Response::json([
					'status'=>'error', 
					'error'=>'There was an error uploading this file.'
				]);
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


	/**
	* Update Image Details (AJAX form in Media Library)
	*/
	public function updateImageDetails()
	{
		if ( Request::ajax() ){
			$update = $this->upload_repo->updateUpload(Input::all());
			$status = ( $update ) ? 'success' : 'error';
			return Response::json([
				'status' => $status
			]);
		}
	}



}