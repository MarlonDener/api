<?php


define('HOST','localhost');
define('USUARIO','root');
define('SENHA','');
define('BANCO','serie_login');
define('DIR_API','api');


if(file_exists('autoload.php')){
	include 'autoload.php';
}else{
	echo 'erro ao carregar';
}


?>