<?php

namespace repository;


class UsuariosRepository{

	private object $MySql;

	public function __construct(){
	}

	

	public function getMySql(){
		return $this->MySql;
	}

	

}



?>