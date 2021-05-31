<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);

class ArqDatabase_model {

    private $pdo;

    function __construct(){
        // Fazendo conexão com o banco de dados
        require_once('conn.php');
        $this->pdo = (new SQliteConnection())->connect();

    }

    /**
     * Retorna informação dos bancos de dados
     */
    function retornaInfoDatabase(){

        $sql = "SELECT * FROM ARQ_DATABASE;";

        $result = $this->pdo->query($sql);

        return $result;

    }

    
}