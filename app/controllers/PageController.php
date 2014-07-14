<?php
use Kickapoo\SocialFeed\TwitterFeed;
use \Guzzle\Http\Client;
use \Guzzle\Plugin\Oauth\OauthPlugin;

class PageController extends BaseController {

	/**
	* Homepage
	*/
	public function home()
	{	
		return View::make('social-test');
	}

}