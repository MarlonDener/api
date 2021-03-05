<?php

namespace Validator;
use Util\Constantes;
use Util\JsonUtil;
use Repository\TokensAutorizadosRepository;
use Service\UsuariosService;
use InvalidArgumentException;
class RequestValidator{

	private $request;
	private const GET = 'GET';
	private const DELETE = 'DELETE';
	private $dadosRequest;
	private object $tokensAutorizadosRepository;
	const USUARIOS = 'USUARIOS';

	function __construct($request){
		$this->request = $request;
		$this->tokensAutorizadosRepository = new TokensAutorizadosRepository;
	}

	public function processarRequest(){
		$retorno = utf8_encode(Constantes::MSG_ERRO_TIPO_ROTA);
		if(in_array($this->request['metodo'],Constantes::TIPO_REQUEST,false)){

			$retorno = $this->direcionarRequest();
			
		}
		return $retorno;
	}


	private function direcionarRequest(){
		if($this->request['metodo'] != self::GET && $this->request['metodo'] != self::DELETE){
				$this->dadosRequest = JsonUtil::tratarCorpoDaRequisicaoJson();
						}
 		@$this->tokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);
		$metodo = $this->request['metodo'];
		return $this->$metodo();//metodo variavel;

	}

	private function get(){
		$retorno = utf8_encode(Constantes::MSG_ERRO_TIPO_ROTA);

		if(in_array($this->request['rota'], Constantes::TIPO_GET)){
			//Se a request, exemplo usuarios existar no tipo get, executa aqui
			switch($this->request['rota']){	
			case self::USUARIOS:
			$UsuariosService = new UsuariosService($this->request);
			$usuarios = $UsuariosService->validarGet();
			$teste = new JsonUtil;
			$teste->processarArrayParaRetornar($usuarios);
			break;

			default:
			echo Constantes::MSG_ERRO_RECURSO_INEXISTENTE;
				
			}

		}else{
				echo Constantes::MSG_ERRO_RECURSO_INEXISTENTE;
		}	
	}


		private function POST()
	{
		$retorno = utf8_encode(Constantes::MSG_ERRO_TIPO_ROTA);

		if(in_array($this->request['rota'], Constantes::TIPO_POST)){
			switch($this->request['rota']){
			case 'USUARIOS':	
			$UsuariosService = new UsuariosService($this->request);
			$UsuariosService->setDadosCorpoRequest($this->dadosRequest);
			$retorno = $UsuariosService->validarPost();
			break;

			default:
			echo 'esse tabela não existe';
			break;
			}
			}else{
				echo Constantes::MSG_ERRO_ID_OBRIGATORIO;
				}

	}




	private function DELETE()
	{
		$retorno = utf8_encode(Constantes::MSG_ERRO_TIPO_ROTA);

		if(in_array($this->request['rota'], Constantes::TIPO_DELETE)){

			$deletar = new UsuariosService($this->request);
			$deletar->validarDelete();

			}else{
				echo Constantes::MSG_ERRO_ID_OBRIGATORIO;
				}

	}

		private function PUT()
	{
		$retorno = utf8_encode(Constantes::MSG_ERRO_TIPO_ROTA);

		if(in_array($this->request['rota'], Constantes::TIPO_PUT)){
			switch($this->request['rota']){
			case 'USUARIOS':	
			$UsuariosService = new UsuariosService($this->request);
			$UsuariosService->setDadosCorpoRequest($this->dadosRequest);
			$retorno = $UsuariosService->validarPut();
			break;

			default:
			echo 'esse tabela não existe';
			break;
			}
			}else{
				echo Constantes::MSG_ERRO_ID_OBRIGATORIO;
				}

	}





}


?>