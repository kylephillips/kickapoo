<?php
use Kickapoo\SocialImport\Import;

class FeedController extends BaseController {


	public function doImport()
	{
		new Import;
		return 'all done.';
	}


}