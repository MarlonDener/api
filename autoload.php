  
<?php
/**
 * AUTOLOAD DE CLASSES PARA O PACOTE 'Classes'
 * @param $classe
 */
function autoload($classe)
{
	include('classes/'.$classe.'.php');
}

spl_autoload_register('autoload');


?>