<?php namespace Kickapoo\Repositories;

use \AppLog;

class AppLogRepository {

	public function getLast()
	{
		return AppLog::where('type','import')->orderBy('created_at', 'desc')->firstOrFail();
	}

}