<?php
namespace Util;


class JsonUtil{


	public function processarArrayParaRetornar($retorno){
		$dados = [];
		$dados[Constantes::TIPO] = Constantes::TIPO_ERRO;
		$dados[Constantes::TIPO] = Constantes::TIPO_SUCESSO;
		$dados['resposta'] = $retorno;
		$this->retornarJson($dados);
	}

	private function retornarJson($json){
		
		header('Content-Type: application/json');
		header('Cache-control: no-cache, no-store, must-revalidate');
		header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');
		echo json_encode($json);exit;
	}

	public function tratarCorpoDaRequisicaoJson(){

		try{
		$postJson = json_decode(file_get_contents('php://input'));
		var_dump($postJson);

		}catch(Exception $exception){
			throw new Exception($exception->getMessage());			
			
		}

		return $postJson;
	}
}


?>