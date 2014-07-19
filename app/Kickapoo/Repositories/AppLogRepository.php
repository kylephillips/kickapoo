<?php namespace Kickapoo\Repositories;

use \AppLog;

class AppLogRepository {

	public function getLast()
	{
		try {
			$last_import = AppLog::where('type','import')->orderBy('created_at', 'desc')->firstOrFail();
		} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
			return 'No imports yet.';
		}
		$date = date('D, M jS, g:i:s a', strtotime($last_import->created_at));
		return $date; 
	}

}