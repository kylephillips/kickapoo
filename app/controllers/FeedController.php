<?php
use Kickapoo\SocialImport\Import;

class FeedController extends BaseController {

	/**
	* Manually run an import
	*/
	public function doImport()
	{
		if ( Request::ajax() ){
			new Import;
			return Response::json(['status' => 'success']);
		}
	}


}