<?php

namespace Service;
use Repository\UsuariosRepository;
use Util\Constantes;
use DB\MySql;

class UsuariosService{

public $usuarios = 'usuarios';
private array $dados;
public const RECURSOS_GET = ['listar'];
private object $UsuariosRepository;
public const RECURSOS_DELETE = ['delete'];
public const RECURSOS_POST = ['cadastrar'];
public const RECURSOS_PUT= ['atualizar'];

public function __construct($dados = []){
	$this->dados = $dados;
}

public function validarGet(){

	$retorno = null;
	$recurso = $this->dados['recurso'];

	if(in_array($recurso, self::RECURSOS_GET)){
		$retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
	}else{
		echo Constantes::MSG_ERRO_RECURSO_INEXISTENTE;		
	}

	if($retorno === null){
		  'NENHUM REGISTRO FOI ENCONTRADO';
	}

	return $retorno;

}
public function validarDelete(){

	$retorno = null;
	$recurso = $this->dados['recurso'];
	if(in_array($recurso, self::RECURSOS_DELETE)){
		if($this->dados['id'] > 0){
			$retorno = $this->$recurso();
		}else{
		echo 'é necessário informar ao menos um usuario para deletar';
		}
	}else{
		echo Constantes::MSG_ERRO_SEM_RETORNO;
	}

	if($retorno === null){
		  'NENHUM REGISTRO FOI ENCONTRADO';
	}

	return $retorno;

}

public function validarPut(){

	$retorno = null;
	$recurso = $this->dados['recurso'];
	if(in_array($recurso, self::RECURSOS_PUT)){
		if($this->dados['id'] > 0){
			$retorno = $this->$recurso();
			echo 'chegou aqui';
		}else{
		echo 'é necessário informar ao menos um usuario para deletar';
		}
	}else{
		echo Constantes::MSG_ERRO_SEM_RETORNO;
	}

	if($retorno === null){
		  'NENHUM REGISTRO FOI ENCONTRADO';
	}

	return $retorno;

}

private function listar(){
	$banco = new MySql;
	$execute = $banco->getAll('usuarios');
	return $execute;

}

private function delete(){
	$banco = new MySql;
	$deletando = $banco->delete('usuarios',$this->dados['id']);
	echo $deletando;
}


private function getOneByKey(){
		$bancoDados = new MySql;
		$executar = $bancoDados->getOnlyUserByKey('usuarios',$this->dados['id']);
		return $executar;
}

private $dadosCorpoRequest;

public function setDadosCorpoRequest($dadosRequest){
$this->dadosCorpoRequest = $dadosRequest;

}


public function validarPost(){

	$retorno = null;
	$recurso = $this->dados['recurso'];
	if(in_array($recurso, self::RECURSOS_POST)){
		$retorno = $this->$recurso();
	}else{
		echo Constantes::MSG_ERRO_SEM_RETORNO;
	}

	if($retorno === null){
		  'NENHUM REGISTRO FOI ENCONTRADO';
	}

	return $retorno;

}

private function cadastrar(){


	if(isset($this->dadosCorpoRequest->login) && isset($this->dadosCorpoRequest->senha)){

	$login = $this->dadosCorpoRequest->login;
	$senha = $this->dadosCorpoRequest->senha;
	$exec = new MySql;
	if($exec->insertUser($login,$senha) > 0){
		echo 'Usuario inserido com sucesso';
	}else{
		echo Constantes::MSG_ERRO_GENERICO;
	}


	echo 'certo';
	}else{
		echo 'Paramêtros invalidos';
	}
}


private function atualizar(){
	$exec = new MySql;
	if($exec->updateUser($this->dados['id'],$this->dadosCorpoRequest) > 0){
		echo 'deu certo';
	}else{
		echo 'deu erro';
	}
}

}


?>