<?php

namespace repository;
use DB\MySql;
use Util\Constantes;


class TokensAutorizadosRepository{

	private object $MySql;

	public const TABELA = "tokens_autorizados";

	public function __construct(){
		$this->MySql = new MySql;
	}

	public function validarToken($token){

		$token = str_replace('Basic ', '', $token);
		$token = str_replace('=', '', $token);

		if($token){
			$consultaToken = 'SELECT id FROM `tokens_autorizados` WHERE token = :token AND status = :status';
			$stmt = $this->getMySQL()->getDb()->prepare($consultaToken);
			$stmt->bindValue(':token',$token);
			$stmt->bindValue(':status',Constantes::SIM);
			if($stmt->rowCount() != 1){
				header('HTTP/1.1 401 Unauthorized');
			}
			//token deu certo
		}
		else
		{
			echo Constantes::MSG_ERRO_TOKEN_VAZIO;			
		}

	}


	public function getMySql(){
		return $this->MySql;
	}
}



?>