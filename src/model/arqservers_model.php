<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);

class ArqServers_Model {

    private $pdo;

    function __construct(){
        // Fazendo conexão com o banco de dados
        require_once('conn.php');
        $this->pdo = new SQliteConnection();
        $this->pdo = $this->pdo->connect();

    }

    /**
     * Retorna informação dos servidores
     */
    function retornaInfoArqServers(){

        $sql = "SELECT * FROM Aplicacoes.GovTi.ARQ_SERVERS;";

        $result = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    /**
     * Retorna informação dos servidores com um parâmetro de filtro
     */
    function retornaInfoArqServerFiltro($palavraBuscada){

        $palavraBuscada = strtolower($palavraBuscada);

        $search = "%$palavraBuscada%";

        $sql = "    SELECT      DISTINCT SRV.*
                    FROM        Aplicacoes.GovTi.ARQ_SERVERS AS SRV 
                    LEFT JOIN   Aplicacoes.GovTi.SUBITEMS_ARQ_SERVERS SUB ON SUB.ID_SERVIDOR = SRV.ID
                    WHERE       lower(SRV.NOME) LIKE :palavra_buscada
                    OR          lower(SRV.OBJETIVO) LIKE :palavra_buscada
                    OR          lower(SRV.LINGUAGEM) LIKE :palavra_buscada
                    OR          lower(SUB.ITEM) LIKE :palavra_buscada
                    OR          lower(SUB.DESCRICAO) LIKE :palavra_buscada
                
                ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('palavra_buscada' => $search));

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    /**
     * Adiciona novo registro a respeito de servidor na tabela
     */
    function insereInfoArqServer($dadosServidor){
        
        $nome       = $dadosServidor['nome'];
        $objetivo   = $dadosServidor['objetivo'];
        $linguagem  = $dadosServidor['linguagem'];
        $ativo      = $dadosServidor['ativo'];

        $sql = "    INSERT INTO Aplicacoes.GovTi.ARQ_SERVERS (NOME, OBJETIVO, LINGUAGEM, ATIVO, DATA_INSERT)
                    VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";

        $stmt  = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $objetivo, $linguagem, $ativo));

        return $result;
    }

    /**
     * Adiciona novo registro a respeito do item de um servidor na tabela
     */
    function insereInfoItemArqServer($dadosServidor){
        
        $id_servidor     = $dadosServidor['id_servidor'];
        $nome            = $dadosServidor['nome'];
        $descricao       = $dadosServidor['descricao'];
        $ativo           = $dadosServidor['ativo'];

        $sql = "    INSERT INTO Aplicacoes.GovTi.SUBITEMS_ARQ_SERVERS (ID_SERVIDOR, ITEM, DESCRICAO, ATIVO, DATA_INSERT)
                    VALUES ( ?, ?, ?, ?, CURRENT_TIMESTAMP)";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($id_servidor, $nome, $descricao, $ativo));

        return $result;
    }


    /**
     * Delete um registro do servidor presente na tabela
     */
    function deletaInfoArqServer($dadosServidor){

        $id_servidor = $dadosServidor['id_servidor'];

        $sql = "    DELETE  FROM Aplicacoes.GovTi.ARQ_SERVERS
                    WHERE   ID = :id_servidor;

                    DELETE FROM Aplicacoes.GovTi.SUBITEMS_ARQ_SERVERS
                    WHERE  ID_SERVIDOR = :id_servidor;

                ";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array("id_servidor" => $id_servidor));

        return $result;

    }

    /**
     * Delete um registro de um subitem de um servidor presente na tabela
     */
    function deletaInfoItemArqServer($dadosServidor){

        $id_item_servidor = $dadosServidor['id_item_servidor'];

        $sql = "    DELETE  FROM Aplicacoes.GovTi.SUBITEMS_ARQ_SERVERS
                    WHERE   id = :id_item_servidor
                ";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array("id_item_servidor" => $id_item_servidor));

        return $result;

    }
    /**
     * Atualiza um registro do servidor presente na tabela
     */
    function updateInfoArqServer($dadosServidor){

        $id_servidor = $dadosServidor['id_servidor'];
        $nome = $dadosServidor['nome'];
        $objetivo = $dadosServidor['objetivo'];
        $linguagem = $dadosServidor['linguagem'];
        $ativo = $dadosServidor['ativo'];

        $sql = "    UPDATE Aplicacoes.GovTi.ARQ_SERVERS SET       NOME = ?
                                                ,OBJETIVO = ?
                                                ,LINGUAGEM = ?
                                                ,ATIVO = ?
                    WHERE   ID = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $objetivo, $linguagem, $ativo, $id_servidor));

        return $result;
        
    }

    /**
     * Atualiza um registro do item do servidor presente na tabela
     */
    function updateItemInfoArqServer($dadosServidor){

        $id_item    = $dadosServidor['id_item'];
        $nome       = $dadosServidor['nome'];
        $descricao  = $dadosServidor['descricao'];
        $ativo      = $dadosServidor['ativo'];

        $sql = "    UPDATE Aplicacoes.GovTi.SUBITEMS_ARQ_SERVERS SET  ITEM = ?
                                                                    ,DESCRICAO = ?
                                                                    ,ATIVO = ?
                    WHERE   ID = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $descricao, $ativo, $id_item));

        return $result;
        
    }


    /**
     * Efetua uma busca na tabela que armazena os sub-items relacionado ao ID do servidor fornecido
     */
    function retornaSubItemsServer($dadosServidor){

        $id_servidor = $dadosServidor['id_servidor'];

        $sql = "    SELECT  *
                    FROM    Aplicacoes.GovTi.SUBITEMS_ARQ_SERVERS
                    WHERE   ID_SERVIDOR = ?";

        $stmt = $this->pdo->prepare($sql);                
        $stmt->execute(array($id_servidor));
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}

?>
