<?php namespace Kickapoo\SocialFeedSingle;

use \Guzzle\Http\Client;
use \Guzzle\Plugin\Oauth\OauthPlugin;

class Tweet {

	/**
	* API Credentials
	* @var array
	*/
	private $credentials;


	public function __construct()
	{
		$this->setCredentials();
	}


	/**
	* Set the API Credentials
	*/
	public function setCredentials()
	{
		$this->credentials = [
			'api_key' => $_ENV['twitter_api_key'],
			'api_secret' => $_ENV['twitter_api_secret'],
			'access_token' => $_ENV['twitter_access_token'],
			'access_token_secret' => $_ENV['twitter_access_token_secret']
		];
	}

	/**
	* Get the feed from the API
	*/
	public function feed($id)
	{
		$twitter_client = new Client('https://api.twitter.com/1.1');
		$twitter_client->addSubscriber(new OauthPlugin(array(
			'consumer_key' => $this->credentials['api_key'],
			'consumer_secret' => $this->credentials['api_secret'],
			'token' => $this->credentials['access_token'],
			'token_secret' => $this->credentials['access_token_secret']
		)));
		$request = $twitter_client->get('statuses/show.json');
		$request->getQuery()->set('id', $id);
		

		try {
			$response = $request->send();
			$feed = json_decode($response->getBody());
		} 
		catch (\Exception $e) {
			\Error::create(['time' => date("Y-m-d H:i:s"), 'message' => $e]);
			return false;
		}

		return $feed;
	}

}