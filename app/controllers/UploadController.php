<?php
class UploadController extends BaseController {

	/**
	* Upload a file through editor
	*/
	public function editorUpload()
	{
		$file = Input::file('file');
		$filename = time() . '_' . $file->getClientOriginalName();
		$destination = public_path() . '/assets/uploads/page_images/';
		$uploadSuccess = Input::file('file')->move($destination, $filename);
		$newfile = '/assets/uploads/page_images/' . $filename;

		if ( $uploadSuccess ){
			Upload::create([
				'file' => $filename,
				'folder' => '/assets/uploads/page_images'
			]);
			return Response::json(['filelink' => $newfile]);
		} else {
			return Response::json(['error'=>'There was an error uploading this file.']);
		}

	}

}