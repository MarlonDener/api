<?php

namespace DB;

use InvalidArgumentException;
use PDO;
use PDOException;
use Util\Constantes;


class MySQL
{
    private object $db;

    /**
     * MySQL constructor.
     */
    public function __construct()
    {
        $this->db = $this->setDB();
    }

    /**
     * @return PDO
     */
    public function setDB()
    {
        try {
            return new PDO(
                'mysql:host=' . HOST . '; dbname=' . BANCO . ';', USUARIO, SENHA
            );
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    /**
     * @param $tabela
     * @param $id
     * @return string
     */
    public function delete($tabela, $id)
    {
        $consultaDelete = 'DELETE FROM ' . $tabela . ' WHERE id = :id';
        if ($tabela && $id) {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare($consultaDelete);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->db->commit();
                return Constantes::MSG_DELETADO_SUCESSO;
            }
            $this->db->rollBack();
            echo Constantes::MSG_ERRO_SEM_RETORNO;
        }
        echo Constantes::MSG_ERRO_GENERICO;
    }

    /**
     * @param $tabela
     * @return array
     */
    public function getAll($tabela)
    {
        if ($tabela) {
            $consulta = 'SELECT * FROM ' . $tabela;
            $stmt = $this->db->query($consulta);
            $registros = $stmt->fetchAll($this->db::FETCH_ASSOC);
            if (is_array($registros) && count($registros) > 0) {
                return $registros;
            }
        }
        throw new InvalidArgumentException(Constantes::MSG_ERRO_SEM_RETORNO);
        }


         /**
     * @param $tabela
     * @param $id
     * @return mixed
     */
    public function getOnlyUserByKey($tabela, $id)
    {
        if ($tabela && $id) {
            $consulta = 'SELECT * FROM ' . $tabela . ' WHERE id = :id';
            $stmt = $this->db->prepare($consulta);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $totalRegistros = $stmt->rowCount();
            if ($totalRegistros === 1) {
                return $stmt->fetch($this->db::FETCH_ASSOC);
            }
            throw new InvalidArgumentException(Constantes::MSG_ERRO_SEM_RETORNO);
        }

        throw new InvalidArgumentException(Constantes::MSG_ERRO_ID_OBRIGATORIO);
    }

    /**
     * @return object|PDO
     */
    public function getDb()
    {
        return $this->db;
    }


    public function insertUser($login,$senha){
     $consultaInsert = 'INSERT INTO `usuarios` VALUES(null,?,?)';
     $stmt = $this->db->prepare($consultaInsert);
     $stmt->execute(array($login,$senha));
     return $stmt->rowCount();
     
        
    }

    public function updateUser($id,$dados){
     $consultaUpdate = 'UPDATE `usuarios` SET login = :login, senha = :senha WHERE id = :id';
     $stmt = $this->db->prepare($consultaUpdate);
     $stmt->bindValue(":login",$dados->login);

     $stmt->bindValue(":senha",$dados->senha);
     $stmt->bindValue(":id",$id);
     $stmt->execute();
    return $stmt->rowCount();
     
        
    }
}




?>