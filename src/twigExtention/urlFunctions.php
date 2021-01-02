<?php
namespace src\twigExtention;

class urlFunctions{
	public static function get_current_url(){
		return empty($_SERVER["HTTPS"]) ? "http://" : "https://".$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	}
}
?>