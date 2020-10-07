<?php


namespace Util;


class GitHubUtil{


	static function connect($url,$method="GET",$param=array()){
		$baseUrl = 'https://api.github.com';

		if($method!="GET"){
			$data = json_encode($param,JSON_UNESCAPED_UNICODE);
		} else {
			$data = null;
		}

		$header=array(
			"User-Agent: ACTLaboratory-webadmin",
			"Accept: application/vnd.github.v3+json",

			"Authorization: token ".getenv("GITHUB_TOKEN"),
			"Time-Zone: Asia / Tokyo",
			"Content-Type: application/json; charset=utf-8",
			"Content-Length:".strlen($data)
		);

		$context = array(
			"http" => array(
				"method"  => $method,
				"header"  => implode("\r\n", $header),
				"content" => $data,
				"ignore_errors"=>true
				)
		);
		$result=file_get_contents($baseUrl.$url, false, stream_context_create($context));
		//var_dump($http_response_header);
		return json_decode($result,true);
	}

	static function get_assets($assets_url){
		$header=array(
			"Accept: application/octet-stream",
			"User-Agent: ACTLaboratory-webadmin",
			"Authorization: token ".getenv("GITHUB_TOKEN")
		);
		
		$context = array(
			"http" => array(
				"method"  => "GET",
				"header"  => implode("\r\n", $header),
				"ignore_errors"=>true
				)
		);
		$content = file_get_contents($assets_url, false, stream_context_create($context));
		return $content;
	}

}