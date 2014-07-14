<?php namespace Kickapoo\Libraries;

class Parse {

	/**
	* Parse provided text for links
	* @return string - text wrapped in link
	*/
	public static function links($text)
	{
		$text = preg_replace(
			'@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@',
			'<a href="$1">$1</a>',
		$text);
		return $text;
	}


	/**
	* Parse provided text for hashtags
	* @return string 
	*/
	public static function twitterHashtags($text)
	{
		$text = preg_replace(
			'/\s+#(\w+)/',
			' <a href="http://search.twitter.com/search?q=%23$1">#$1</a>',
		$text);
		return $text;
	}


	/**
	* Tweet Text
	*/
	public static function tweet($text)
	{
		$text = self::links($text);
		$text = self::twitterHashtags($text);
		return $text;
	}


	/**
	* Instagram Text
	*/
	public static function gram($text)
	{
		$text = self::links($text);
		return $text;
	}

}