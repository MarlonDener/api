<?php

namespace Util;

class RotasUtil{

	public static function getRotas(){

		$urls = self::getUrls();
		$REQUEST = [];
		$REQUEST['rota'] = strtoupper($urls[0]);
		$REQUEST['recurso'] = $urls[1] ?? null;
		$REQUEST['id'] = $urls[2] ?? null;
		$REQUEST['metodo'] = strtoupper($_SERVER['REQUEST_METHOD']);
		
		return $REQUEST;
 
	}

	public static function getUrls(){

		$uri = str_replace('/'.DIR_API, '', $_SERVER['REQUEST_URI']);
		$MyUrls = explode('/', trim($uri,'/'));

		return $MyUrls;
	}
}


?>