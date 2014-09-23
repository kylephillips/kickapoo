<?php namespace Kickapoo\Repositories;

use \Upload;

class UploadRepository {

	/**
	* Get all uploads for a specified directory
	* @param string
	*/
	public function getDirectory($directory = 'page_images')
	{
		$folder = '/assets/uploads/' . $directory . '/';
		return Upload::where('folder', $folder)->get();
	}


	/**
	* Get an array of all directories
	* @return array
	*/
	public function getDirectoriesArray()
	{
		$directories = Upload::groupBy('folder')->get();
		if ( count($directories) > 0 ){
			$i = 1;
			foreach($directories as $directory)
			{
				$folder_name = explode('/', $directory['folder']);
				$folder_name = $folder_name[sizeof($folder_name)-2];
				$folders[$i]['path'] = $directory['folder'];
				$folders[$i]['name'] = $folder_name;
				$i++;
			}
			return $folders;
		} else {
			return false;
		}
	}

}