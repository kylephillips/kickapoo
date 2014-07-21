<?php namespace Kickapoo\SocialFeed;

use \Guzzle\Http\Client;
use \Guzzle\Plugin\Oauth\OauthPlugin;
use \Config;
use \Error;
use \DB;
use \Kickapoo\Libraries\Parse;

class TwitterFeed implements SocialFeed {

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


	public function __construct()
	{
		$this->setCredentials();
		$this->setSearch();
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
	* Set the Search Term
	*/
	public function setSearch()
	{
		$this->search_term = DB::table('settings')->where('key', 'twitter_search')->pluck('value');
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
		$request = $twitter_client->get('search/tweets.json');
		$request->getQuery()->set('q', $this->search_term);
		$response = $request->send();

		try {
			$feed = json_decode($response->getBody());
			$this->feed = $feed->statuses;
		} catch (\Exception $e) {
			Error::create(['time' => date("Y-m-d H:i:s"), 'message' => $e]);
			return false;
		}
	}


	/**
	* Format the feed into an array
	*/
	public function formatFeed()
	{
		foreach ( $this->feed as $key=>$item )
		{
			$this->feed_formatted[$key]['id'] = $item->id;
			$this->feed_formatted[$key]['text'] = Parse::tweet($item->text);
			$this->feed_formatted[$key]['is_retweet'] = ( isset($item->retweeted_status) ) ? true : false;
			$this->feed_formatted[$key]['date'] = $item->created_at;
			$this->feed_formatted[$key]['language_code'] = $item->lang;
			$this->feed_formatted[$key]['retweet_count'] = $item->retweet_count;
			$this->feed_formatted[$key]['favorite_count'] = $item->favorite_count;
			$this->feed_formatted[$key]['screen_name'] = $item->user->screen_name;
			$this->feed_formatted[$key]['profile_image'] = $item->user->profile_image_url;
			$this->feed_formatted[$key]['location'] = $item->user->location;
			$this->feed_formatted[$key]['media'] = ( isset($item->entities->media) ) ? $item->entities->media[0]->media_url : null;
			$this->feed_formatted[$key]['coordinates'] = ( isset($item->coordinates) ) ? $item->coordinates->coordinates : null;
		}
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