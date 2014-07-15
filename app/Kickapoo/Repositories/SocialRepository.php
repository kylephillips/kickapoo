<?php namespace Kickapoo\Repositories;
use \Tweet;

class SocialRepository {

	public function getTweets()
	{
		$tweets = Tweet::get();
		return $tweets->toArray();
	}

}