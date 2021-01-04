<?php
namespace Util;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterUtil{
	public static function tweet(string $text, string $url = ""){
		$abs_url = $url;
		if($url != ""){
			$abs_url = UrlUtil::toAbsUrl($url);
		}
		$connection = new TwitterOAuth(getenv("TWITTER_API_KEY"), getenv("TWITTER_API_SECRET"), getenv("TWITTER_ACCESS_TOKEN"), getenv("TWITTER_ACCESS_TOKEN_SECRET"));
		$result = $connection->post("statuses/update", ["status" => $text."\n".$abs_url]);
		return $result;
	}
}
