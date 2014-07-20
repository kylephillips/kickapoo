<?php namespace Kickapoo\SocialFeed;

use \Guzzle\Http\Client;
use \Guzzle\Plugin\Oauth\OauthPlugin;
use \Config;
use \Error;
use \DB;
use \Kickapoo\Libraries\Parse;

class InstagramFeed implements SocialFeed {

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


	public function __construct($id = null)
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
			'client_id' => $_ENV['instagram_client_id']
		];
	}


	/**
	* Set the Search Term
	*/
	public function setSearch()
	{
		$this->search_term = DB::table('settings')->where('key', 'instagram_search')->pluck('value');
	}


	/**
	* Get the feed from the API
	*/
	public function getFeed()
	{
		$instagram_client = new Client('https://api.instagram.com/v1/tags');
		$request = $instagram_client->get($this->search_term . '/media/recent');
		$request->getQuery()->set('client_id', $this->credentials['client_id']);
		$response = $request->send();
		try {
			$feed = json_decode($response->getBody());
			$this->feed = $feed->data;
		} catch (\Guzzle\Http\Exception\ServerErrorResponseException $e) {
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
			$this->feed_formatted[$key]['date'] = $item->created_time;
			$this->feed_formatted[$key]['link'] = $item->link;
			$this->feed_formatted[$key]['type'] = $item->type;
			$this->feed_formatted[$key]['like_count'] = $item->likes->count;
			$this->feed_formatted[$key]['image'] = ( $item->type == 'image' ) ? $item->images->standard_resolution->url : null;
			$this->feed_formatted[$key]['video_url'] = ( $item->type == 'video' ) ? $item->videos->low_resolution->url : null;
			$this->feed_formatted[$key]['caption'] = ( isset($item->caption->text) ) ? Parse::gram($item->caption->text) : null;
			$this->feed_formatted[$key]['user_id'] = $item->user->id;
			$this->feed_formatted[$key]['screen_name'] = $item->user->username;
			$this->feed_formatted[$key]['profile_image'] = $item->user->profile_picture;
			$this->feed_formatted[$key]['latitude'] = ( isset($item->location->latitude) ) ? $item->location->latitude : null;
			$this->feed_formatted[$key]['longitude'] = ( isset($item->location->longitude) ) ? $item->location->longitude : null;
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