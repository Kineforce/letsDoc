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

    /**
     * Adiciona novo registro a respeito de database na tabela
     */
    function insereInfoDatabase($dadosServidor){
        
        $nome       = $dadosServidor['nome'];
        $descricao   = $dadosServidor['descricao'];
        $ambiente  = $dadosServidor['ambiente'];
        $ativo      = $dadosServidor['ativo'];

        $sql = "    INSERT INTO ARQ_DATABASE (NOME, DESCRICAO, AMBIENTE, ATIVO, DATA_INSERT)
                    VALUES ('$nome', '$descricao', '$ambiente', '$ativo', CURRENT_TIMESTAMP)";

        $result = $this->pdo->query($sql);

        return $result;
    }

     /**
     * Delete um registro de database presente na tabela
     */
    function deletaInfoDatabase($dadosServidor){

        $id_database = $dadosServidor['id_database'];

        $sql = "    DELETE  FROM ARQ_DATABASE
                    WHERE   id = '$id_database'
                ";

        $result = $this->pdo->query($sql);

        return $result;

    }
    
}