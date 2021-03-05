<?php

include('bootstrap.php');

use Validator\RequestValidator;
use Util\RotasUtil;
use Util\JsonUtil;


try {	
	//Cria as rotas
	$rota = RotasUtil::getRotas();
	//inicia a request, passando as rotas como parâmetro
	$RequestValidator = new RequestValidator($rota);

	$retorno = $RequestValidator->processarRequest();


    } catch(Exception $exception){

    	echo json_encode([

    		Constantes::TIPO => Constantes::TIPO_ERRO,
    		Constantes::RESPOSTA => utf8_encode($exception->getMessage())


    	]);
	
	}	

?>