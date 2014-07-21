<?php namespace Kickapoo\SocialFeed;
/**
* Social Feed
* Connects to Social API, parses response, and creates simple array with API content
*/
abstract class SocialFeed {
	
	/**
	* Set the API Credentials
	* Credentials stored environment var files
	*/
	public function setCredentials(){}

	/**
	* Set the Search Term
	* Search terms stored in DB settings table
	*/
	public function setSearch(){}

	/**
	* Get the feed from the API
	* Uses Guzzle package to connect to API and sets the feed property with response
	*/
	public function getFeed(){}

	/**
	* Format the feed into an array
	*/
	public function formatFeed(){}

	/**
	* Return the Feed (unformatted, raw feed object)
	*/
	public function feed(){}

	/**
	* Return the Formatted Feed (as array, only fields that are specified)
	*/
	public function formatted(){}

}