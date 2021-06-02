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
     * Retorna informação dos servidores com um parâmetro de filtro
     */
    function retornaInfoArqServerFiltro($palavraBuscada){

        $palavraBuscada = strtolower($palavraBuscada);

        $sql = "    SELECT      DISTINCT DB.*
                    FROM        ARQ_DATABASE AS DB 
                    LEFT JOIN   SUBITEMS_ARQ_DATABASE SUB ON SUB.ID_DATABASE = DB.ID
                    WHERE       lower(DB.NOME) LIKE '%$palavraBuscada%'
                    OR          lower(DB.DESCRICAO) LIKE '%$palavraBuscada%'
                    OR          lower(SUB.NOME) LIKE '%$palavraBuscada%'
                    OR          lower(SUB.DESCRICAO) LIKE '%$palavraBuscada%'
                
                ";

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

    /**
     * Delete um registro de database presente na tabela
     */
    function deletaInfoItemDatabase($dadosServidor){

        $id_database = $dadosServidor['id_item_database'];

        $sql = "    DELETE  FROM SUBITEMS_ARQ_DATABASE
                    WHERE   id = '$id_database'
                ";

        $result = $this->pdo->query($sql);

        return $result;

    }


     /**
     * Atualiza um registro de database presente na tabela
     */
    function updateInfoDatabase($dadosServidor){

        $id_database = $dadosServidor['id_database'];
        $nome = $dadosServidor['nome'];
        $descricao = $dadosServidor['descricao'];
        $ambiente = $dadosServidor['ambiente'];
        $ativo = $dadosServidor['ativo'];

        $sql = "    UPDATE ARQ_DATABASE SET          NOME = '$nome'
                                                    ,DESCRICAO = '$descricao'
                                                    ,AMBIENTE = '$ambiente'
                                                    ,ATIVO = '$ativo'
                    WHERE   ID = '$id_database'
        ";

        $result = $this->pdo->query($sql);

        return $result;
        
    }

    /**
     * Atualiza um registro de database presente na tabela
     */
    function updateDatabaseItem($dadosServidor){

        $id_item = $dadosServidor['id_item_database'];
        $nome = $dadosServidor['nome'];
        $descricao = $dadosServidor['descricao'];

        $sql = "    UPDATE SUBITEMS_ARQ_DATABASE SET     NOME = '$nome'
                                                        ,DESCRICAO = '$descricao'
                    WHERE   ID = '$id_item'
        ";

        $result = $this->pdo->query($sql);

        return $result;
        
    }



    /**
     * Efetua uma busca na tabela que armazena os sub-items relacionado ao ID da tabela fornecida
     */
    function retornaSubItemsDatabase($dadosServidor){

        $id_database = $dadosServidor['id_database'];

        $sql = "    SELECT  *
                    FROM    SUBITEMS_ARQ_DATABASE
                    WHERE   ID_DATABASE = '$id_database'";

        $result = $this->pdo->query($sql);                

        return $result;
    }
    

    /**
    * Adiciona novo registro a respeito do item de um servidor na tabela
    */   
    function insereInfoItemDatabase($dadosServidor){

        $id_servidor     = $dadosServidor['id_database'];
        $nome            = $dadosServidor['nome'];
        $descricao       = $dadosServidor['descricao'];

        $sql = "    INSERT INTO SUBITEMS_ARQ_DATABASE (ID_DATABASE, NOME, DESCRICAO, DATA_INSERT)
                    VALUES ('$id_servidor', '$nome', '$descricao', CURRENT_TIMESTAMP)";

        $result = $this->pdo->query($sql);

        return $result;

    }

}