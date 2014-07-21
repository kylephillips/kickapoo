<?php namespace Kickapoo\SocialFeed;

use \Guzzle\Http\Client;
use \Guzzle\Plugin\Oauth\OauthPlugin;
use \Config;
use \Error;
use \DB;
use \Kickapoo\Libraries\Parse;

class InstagramFeedSingle extends SocialFeed {

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
		$this->search_term = $id;
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
	* Get the feed from the API
	*/
	public function getFeed()
	{
		$instagram_client = new Client('https://api.instagram.com//');
		$request = $instagram_client->get('v1/media/shortcode/' . $this->search_term);
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
		if ( !$this->feed ) return false;
		$this->feed_formatted[0]['id'] = $this->feed->id;
		$this->feed_formatted[0]['date'] = $this->feed->created_time;
		$this->feed_formatted[0]['link'] = $this->feed->link;
		$this->feed_formatted[0]['type'] = $this->feed->type;
		$this->feed_formatted[0]['like_count'] = $this->feed->likes->count;
		$this->feed_formatted[0]['image'] = ( $this->feed->type == 'image' ) ? $this->feed->images->standard_resolution->url : null;
		$this->feed_formatted[0]['video_url'] = ( $this->feed->type == 'video' ) ? $this->feed->videos->low_resolution->url : null;
		$this->feed_formatted[0]['caption'] = ( isset($this->feed->caption->text) ) ? Parse::gram($this->feed->caption->text) : null;
		$this->feed_formatted[0]['user_id'] = $this->feed->user->id;
		$this->feed_formatted[0]['screen_name'] = $this->feed->user->username;
		$this->feed_formatted[0]['profile_image'] = $this->feed->user->profile_picture;
		$this->feed_formatted[0]['latitude'] = ( isset($this->feed->location->latitude) ) ? $this->feed->location->latitude : null;
		$this->feed_formatted[0]['longitude'] = ( isset($this->feed->location->longitude) ) ? $this->feed->location->longitude : null;
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