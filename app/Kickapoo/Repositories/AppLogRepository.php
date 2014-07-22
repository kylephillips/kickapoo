<?php namespace Kickapoo\Repositories;

use \AppLog;

class AppLogRepository {

	/**
	* Format a date
	*/
	private function formatDate($date)
	{
		$date = date('D, M jS, g:i:s a', strtotime($date));
		return $date;
	}

	/**
	* Get the last Import date
	*/
	public function getLastImport()
	{
		try {
			$last_import = AppLog::where('type','import')->orderBy('created_at', 'desc')->firstOrFail();
		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
			return 'No imports yet.';
		}
		$data = [
			'date' => $this->formatDate($last_import->created_at), 
			'count' => $last_import->description
		];
		return $data;
	}

	/**
	* Get the last trash emptied date
	*/
	public function getLastTrash()
	{
		try {
			$last_trash = AppLog::where('type','trash')->orderBy('created_at', 'desc')->firstOrFail();
		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
			return 'Trash has not been emptied yet.';
		}
		return $this->formatDate($last_trash->created_at);
	}

}