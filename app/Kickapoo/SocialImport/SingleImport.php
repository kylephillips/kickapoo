<?php namespace Kickapoo\SocialImport;

use Kickapoo\SocialFeed\TwitterFeedSingle as Tweet;
use Kickapoo\SocialFeed\InstagramFeedSingle as Gram;

class SingleImport {

	/**
	* Error
	*/
	public $error;


	/**
	* Import a Single Tweet
	*/
	public function importTweet($id)
	{
		$twitter_feed = new Tweet($id);
		$feed = $twitter_feed->formatted();
		
		if (!$feed){
			$this->error = 'There was an error retrieving the specified tweet.';
			return false;
		}

		try {
			new TwitterImport($feed);
		} catch (\Kickapoo\Exceptions\PostExistsException $e){
			$this->error = 'Tweet has already been imported.';
			return false;
		} catch (\Kickapoo\Exceptions\TweetRetweetException $e){
			$this->error = 'This is a retweet. Only original tweets may be imported.';
			return false;
		}

		return true;

	}


	/**
	* Import a Single Instagram
	*/
	public function importGram($id)
	{
		$gram_feed = new Gram($id);
		$feed = $gram_feed->formatted();

		if (!$feed){
			$this->error = 'There was an error retrieving the specified Instagram post.';
			return false;
		}

		try {
			new InstagramImport($feed);
		} catch (\Kickapoo\Exceptions\PostExistsException $e){
			$this->error = 'This Instagram post has already been imported.';
			return false;
		}

		return true;

	}

}