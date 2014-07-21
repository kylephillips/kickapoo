<?php namespace Kickapoo\SocialFeed;

use \Guzzle\Http\Client;
use \Guzzle\Plugin\Oauth\OauthPlugin;
use \Kickapoo\Libraries\Parse;

class TwitterFeedSingle extends SocialFeed {

	/**
	* API Credentials
	* @var array
	*/
	private $credentials;

	/**
	* Search for
	* @var string
	* @todo store in DB settings table
	*/
	private $search_term;

	/**
	* Feed Object
	* @var object
	*/
	public $feed;

	/**
	* Formatted Feed Array
	* @var array
	*/
	private $feed_formatted;


	public function __construct($search_term)
	{
		$this->setCredentials();
		$this->search_term = $search_term;
		$this->getFeed();
		$this->formatFeed();
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
	public function getFeed()
	{
		$twitter_client = new Client('https://api.twitter.com/1.1');
		$twitter_client->addSubscriber(new OauthPlugin(array(
			'consumer_key' => $this->credentials['api_key'],
			'consumer_secret' => $this->credentials['api_secret'],
			'token' => $this->credentials['access_token'],
			'token_secret' => $this->credentials['access_token_secret']
		)));
		$request = $twitter_client->get('statuses/show.json');
		$request->getQuery()->set('id', $this->search_term);
		

		try {
			$response = $request->send();
			$feed = json_decode($response->getBody());
		} 
		catch (\Exception $e) {
			\Error::create(['time' => date("Y-m-d H:i:s"), 'message' => $e]);
			return false;
		}

		$this->feed = $feed;
	}

	/**
	* Format the feed into an array
	*/
	public function formatFeed()
	{
		$this->feed_formatted['id'] = $this->feed->id;
		$this->feed_formatted['text'] = Parse::tweet($this->feed->text);
		$this->feed_formatted['is_retweet'] = $this->feed->retweeted;
		$this->feed_formatted['date'] = $this->feed->created_at;
		$this->feed_formatted['language_code'] = $this->feed->lang;
		$this->feed_formatted['retweet_count'] = $this->feed->retweet_count;
		$this->feed_formatted['favorite_count'] = $this->feed->favorite_count;
		$this->feed_formatted['screen_name'] = $this->feed->user->screen_name;
		$this->feed_formatted['profile_image'] = $this->feed->user->profile_image_url;
		$this->feed_formatted['location'] = $this->feed->user->location;
		$this->feed_formatted['media'] = ( isset($this->feed->entities->media) ) ? $this->feed->entities->media[0]->media_url : null;
		$this->feed_formatted['coordinates'] = ( isset($this->feed->coordinates) ) ? $this->feed->coordinates->coordinates : null;
	}


	/**
	* Return the Feed
	*/
	public function feed()
	{
		return $this->feed;
	}


	/**
	* Return the Formatted Feed
	*/
	public function formatted()
	{
		return $this->feed_formatted;
	}

}