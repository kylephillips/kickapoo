<?php namespace Kickapoo\SocialFeed;

use \Guzzle\Http\Client;
use \Guzzle\Plugin\Oauth\OauthPlugin;
use \Error;

class FacebookFeed extends SocialFeed {

	/**
	* API Credentials
	* @var array
	*/
	private $credentials;

	/**
	* Search for
	* @var string
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
		$settings_repo = new \Kickapoo\Repositories\SettingRepository;
		$this->credentials = $settings_repo->socialCreds();
	}


	/**
	* Set the Search Term to Kickapoo's Facebook Page
	*/
	public function setSearch()
	{
		$this->search_term = $this->credentials['facebook_page_id'];
	}


	/**
	* Get the feed from the API
	*/
	public function getFeed()
	{
		try {
			$facebook_client = new Client('https://graph.facebook.com/v2.0');
			$request = $facebook_client->get($this->credentials['facebook_page_id'] . '/feed');
			$request->getQuery()->set('date_format', 'U');
			$request->getQuery()->set('access_token', $this->credentials['facebook_app_token']);
			$response = $request->send();
			$feed = json_decode($response->getBody());
			$this->feed = $feed->data;
		} catch (\Exception $e) {
			Error::create(['time' => date("Y-m-d H:i:s"), 'message' => $e->getMessage()]);
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
			$this->feed_formatted[$key]['id'] = $this->getPostId($item->id);
			$this->feed_formatted[$key]['date'] = $item->created_time;
			$this->feed_formatted[$key]['link'] = ( isset($item->link) ) ? $item->link : null;
			$this->feed_formatted[$key]['type'] = $item->type;
			$this->feed_formatted[$key]['message'] = ( isset($item->message) ) ? $item->message : null;
			$this->feed_formatted[$key]['story'] = ( isset($item->story) ) ? $item->story : null;
			$this->feed_formatted[$key]['user_id'] = $this->getUserId($item->id);
			$this->feed_formatted[$key]['profile_image'] = $this->getProfileImage($this->getUserId($item->id));
			$this->feed_formatted[$key]['picture'] = ( $item->type == 'photo' ) ? $this->getPicture($item->object_id) : null;
			$this->feed_formatted[$key]['caption'] = ( isset($item->caption) ) ? $item->caption : null;
			$this->feed_formatted[$key]['caption_picture'] = ( isset($item->picture) ) ? $item->picture : null;
			$this->feed_formatted[$key]['caption_description'] = ( isset($item->description) ) ? $item->description : null;
		}
	}


	/**
	* Get a picture from the API
	*/
	private function getPicture($id)
	{
		$url = 'https://graph.facebook.com/' . $id . '/picture?type=normal';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$a = curl_exec($ch);
		$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		curl_close($ch);
		return $url;
	}

	/**
	* Get user avatar from the API
	*/
	private function getProfileImage($id)
	{
		$url = 'https://graph.facebook.com/' . $id . '/picture';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$a = curl_exec($ch);
		$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		curl_close($ch);
		return $url;
	}


	/**
	* Get the post id from the facebook id (id combines user & post id)
	* @param string - Facebook ID
	*/
	private function getPostId($facebook_id)
	{
		$string = substr($facebook_id, strpos($facebook_id, '_') + 1);
		return $string;
	}

	/**
	* Get the user ID from the facebook id
	*/
	private function getUserId($facebook_id)
	{
		$string = explode('_', $facebook_id, 2);
		return $string[0];
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