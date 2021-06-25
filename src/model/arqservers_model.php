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
    * Retorna o total de registros da tabela
    */
    function retornaTotalArqServer(){

        $sql_count_total = "    SELECT      COUNT(*) AS TOTAL
                                FROM        aplicacoes.govti.ARQ_SERVERS AS C_SRV
                                LEFT JOIN   aplicacoes.govti.SUBITEMS_ARQ_SERVERS AS C_SUB ON C_SUB.ID_SERVIDOR = C_SRV.ID";

        $stmt_count_total = $this->pdo->query($sql_count_total)->fetchAll(PDO::FETCH_ASSOC);

        return $stmt_count_total;
    }

    /**
    * Retorna todos os registros para exportação em Excel
    */
    function retornaServerExcel(){

        $sql_count_total = "    SELECT      C_SRV.*
                                FROM        aplicacoes.govti.ARQ_SERVERS AS C_SRV
                                LEFT JOIN   aplicacoes.govti.SUBITEMS_ARQ_SERVERS AS C_SUB ON C_SUB.ID_SERVIDOR = C_SRV.ID";

        $stmt_count_total = $this->pdo->query($sql_count_total)->fetchAll(PDO::FETCH_ASSOC);

        return $stmt_count_total;

    }


    /**
     * Retorna informação dos servidores com parâmetros de filtro
     */
    function retornaInfoArqServerFiltro($palavraBuscada, $limit){

        $palavraBuscada = htmlspecialchars(strtolower($palavraBuscada));

        $search = "%$palavraBuscada%";

        $sql = "    SELECT      DISTINCT SRV.*                                
                    FROM        aplicacoes.govti.ARQ_SERVERS AS SRV 
                    LEFT JOIN   aplicacoes.govti.SUBITEMS_ARQ_SERVERS SUB ON SUB.ID_SERVIDOR = SRV.ID
                    WHERE       lower(SRV.NOME) LIKE :palavra_buscada
                    OR          lower(SRV.OBJETIVO) LIKE :palavra_buscada
                    OR          lower(SRV.LINGUAGEM) LIKE :palavra_buscada
                    OR          lower(SUB.ITEM) LIKE :palavra_buscada
                    OR          lower(SUB.DESCRICAO) LIKE :palavra_buscada
                    $limit
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
        
        $nome       = htmlspecialchars($dadosServidor['nome']);
        $objetivo   = htmlspecialchars($dadosServidor['objetivo']);
        $linguagem  = htmlspecialchars($dadosServidor['linguagem']);
        $ativo      = htmlspecialchars($dadosServidor['ativo']);

        $sql = "    INSERT INTO aplicacoes.govti.ARQ_SERVERS (NOME, OBJETIVO, LINGUAGEM, ATIVO, DATA_INSERT)
                    VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";

        $sql_log =  "   INSERT INTO aplicacoes.govti.ARQ_SERVERS_LOG (
                                                     OPERACAO
                                                    ,DATA_OPERACAO
                                                    ,USUARIO
                                                    ,CAMPO_NOME
                                                    ,CAMPO_OBJETIVO
                                                    ,CAMPO_LINGUAGEM
                                                    ,CAMPO_ATIVO
                                                    ,CAMPO_DATA_INSERT
                                                )

                    SELECT   'CADASTRA' AS OPERACAO 
                            ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                            ,'lucas.martins' AS USUARIO
                            ,NOME
                            ,OBJETIVO
                            ,LINGUAGEM
                            ,ATIVO
                            ,DATA_INSERT

                    FROM    aplicacoes.govti.ARQ_SERVERS
                    WHERE   ID = ?

        ";

        $stmt  = $this->pdo->prepare($sql);
        $stmt_log = $this->pdo->prepare($sql_log);
        
        $result = $stmt->execute(array($nome, $objetivo, $linguagem, $ativo));

        $ultimo_id_tabela = $this->pdo->lastInsertId();
        
        $stmt_log->execute(array($ultimo_id_tabela));


        return $result;
    }

    /**
     * Adiciona novo registro a respeito do item de um servidor na tabela
     */
    function insereInfoItemArqServer($dadosServidor){
        
        $id_servidor     = htmlspecialchars($dadosServidor['id_servidor']);
        $nome            = htmlspecialchars($dadosServidor['nome']);
        $descricao       = htmlspecialchars($dadosServidor['descricao']);
        $ativo           = htmlspecialchars($dadosServidor['ativo']);

        $sql = "    INSERT INTO aplicacoes.govti.SUBITEMS_ARQ_SERVERS (ID_SERVIDOR, ITEM, DESCRICAO, ATIVO, DATA_INSERT)
                    VALUES ( ?, ?, ?, ?, CURRENT_TIMESTAMP)";

        $sql_log = "    INSERT INTO aplicacoes.govti.SUBITEMS_ARQ_SERVERS_LOG (  OPERACAO
                                                                ,DATA_OPERACAO
                                                                ,USUARIO
                                                                ,CAMPO_ID_SERVIDOR
                                                                ,CAMPO_ITEM
                                                                ,CAMPO_DESCRICAO
                                                                ,CAMPO_ATIVO
                                                                ,CAMPO_DATA_INSERT
                                                                )

                        SELECT  'CADASTRA' AS OPERACAO
                                ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                ,'lucas.martins' AS USUARIO
                                ,ID_SERVIDOR
                                ,ITEM
                                ,DESCRICAO
                                ,ATIVO
                                ,DATA_INSERT
                        FROM    aplicacoes.govti.SUBITEMS_ARQ_SERVERS
                        WHERE   ID = ?
                        ";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($id_servidor, $nome, $descricao, $ativo));

        $stmt_log = $this->pdo->prepare($sql_log);

        $ultimo_id_tabela = $this->pdo->lastInsertId();

        $stmt_log->execute(array($ultimo_id_tabela));

        return $ultimo_id_tabela;
    }


    /**
     * Delete um registro do servidor presente na tabela
     */
    function deletaInfoArqServer($dadosServidor){

        $id_servidor = htmlspecialchars($dadosServidor['id_servidor']);

        $sql = "    DELETE  FROM aplicacoes.govti.ARQ_SERVERS
                    WHERE   ID = :id_servidor;
                ";

        $sql_item = "   DELETE FROM aplicacoes.govti.SUBITEMS_ARQ_SERVERS
                        WHERE  ID_SERVIDOR = :id_servidor;
                    ";

        $sql_log_arq =  "   INSERT INTO aplicacoes.govti.ARQ_SERVERS_LOG (
                                                            OPERACAO
                                                            ,DATA_OPERACAO
                                                            ,USUARIO
                                                            ,CAMPO_NOME
                                                            ,CAMPO_OBJETIVO
                                                            ,CAMPO_LINGUAGEM
                                                            ,CAMPO_ATIVO
                                                            ,CAMPO_DATA_INSERT
                                                        )

                            SELECT   'REMOVE' AS OPERACAO 
                                    ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                    ,'lucas.martins' AS USUARIO
                                    ,NOME
                                    ,OBJETIVO
                                    ,LINGUAGEM
                                    ,ATIVO
                                    ,DATA_INSERT

                            FROM    aplicacoes.govti.ARQ_SERVERS
                            WHERE   ID = ?

        ";

        $sql_log_item = "    INSERT INTO aplicacoes.govti.SUBITEMS_ARQ_SERVERS_LOG (  OPERACAO
                                                                    ,DATA_OPERACAO
                                                                    ,USUARIO
                                                                    ,CAMPO_ID_SERVIDOR
                                                                    ,CAMPO_ITEM
                                                                    ,CAMPO_DESCRICAO
                                                                    ,CAMPO_ATIVO
                                                                    ,CAMPO_DATA_INSERT
                                                                )

                            SELECT  'REMOVE' AS OPERACAO
                                    ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                    ,'lucas.martins' AS USUARIO
                                    ,ID_SERVIDOR
                                    ,ITEM
                                    ,DESCRICAO
                                    ,ATIVO
                                    ,DATA_INSERT
                            FROM    aplicacoes.govti.SUBITEMS_ARQ_SERVERS
                            WHERE   ID_SERVIDOR = ?
                        ";


        $stmt_item_log = $this->pdo->prepare($sql_log_item);
        $stmt_sql_log_arq = $this->pdo->prepare($sql_log_arq); 

        $stmt_item = $this->pdo->prepare($sql_item);
        $stmt = $this->pdo->prepare($sql);

        $stmt_item_log->execute(array($id_servidor));
        $stmt_sql_log_arq->execute(array($id_servidor));

        $stmt_item->execute(array("id_servidor" => $id_servidor));
        $result = $stmt->execute(array("id_servidor" => $id_servidor));

        return $result;

    }

    /**
     * Delete um registro de um subitem de um servidor presente na tabela
     */
    function deletaInfoItemArqServer($dadosServidor){

        $id_item_servidor = htmlspecialchars($dadosServidor['id_item_servidor']);

        $sql = "    DELETE  FROM aplicacoes.govti.SUBITEMS_ARQ_SERVERS
                    WHERE   id = :id_item_servidor
                ";

        $sql_log_item = "    INSERT INTO aplicacoes.govti.SUBITEMS_ARQ_SERVERS_LOG (  OPERACAO
                                                                    ,DATA_OPERACAO
                                                                    ,USUARIO
                                                                    ,CAMPO_ID_SERVIDOR
                                                                    ,CAMPO_ITEM
                                                                    ,CAMPO_DESCRICAO
                                                                    ,CAMPO_ATIVO
                                                                    ,CAMPO_DATA_INSERT
                                                                )

                            SELECT  'REMOVE' AS OPERACAO
                                    ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                    ,'lucas.martins' AS USUARIO
                                    ,ID_SERVIDOR
                                    ,ITEM
                                    ,DESCRICAO
                                    ,ATIVO
                                    ,DATA_INSERT
                            FROM    aplicacoes.govti.SUBITEMS_ARQ_SERVERS
                            WHERE   ID = ?
                        ";

        $stmt_log = $this->pdo->prepare($sql_log_item);
        $stmt_log->execute(array($id_item_servidor));

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array("id_item_servidor" => $id_item_servidor));

        return $result;

    }
    /**
     * Atualiza um registro do servidor presente na tabela
     */
    function updateInfoArqServer($dadosServidor){

        $id_servidor = htmlspecialchars($dadosServidor['id_servidor']);
        $nome = htmlspecialchars($dadosServidor['nome']);
        $objetivo = htmlspecialchars($dadosServidor['objetivo']);
        $linguagem = htmlspecialchars($dadosServidor['linguagem']);
        $ativo = htmlspecialchars($dadosServidor['ativo']);

        $sql = "    UPDATE aplicacoes.govti.ARQ_SERVERS SET       NOME = ?
                                                ,OBJETIVO = ?
                                                ,LINGUAGEM = ?
                                                ,ATIVO = ?
                    WHERE   ID = ?
        ";

        $sql_log_arq =  "   INSERT INTO aplicacoes.govti.ARQ_SERVERS_LOG (
                                                            OPERACAO
                                                            ,DATA_OPERACAO
                                                            ,USUARIO
                                                            ,CAMPO_NOME
                                                            ,CAMPO_OBJETIVO
                                                            ,CAMPO_LINGUAGEM
                                                            ,CAMPO_ATIVO
                                                            ,CAMPO_DATA_INSERT
                                                        )

                            SELECT   'ALTERA' AS OPERACAO 
                                    ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                    ,'lucas.martins' AS USUARIO
                                    ,NOME
                                    ,OBJETIVO
                                    ,LINGUAGEM
                                    ,ATIVO
                                    ,DATA_INSERT

                            FROM    aplicacoes.govti.ARQ_SERVERS
                            WHERE   ID = ?

        ";


        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $objetivo, $linguagem, $ativo, $id_servidor));

        $stmt_log = $this->pdo->prepare($sql_log_arq);    
        $stmt_log->execute(array($id_servidor));

        return $result;
        
    }

    /**
     * Atualiza um registro do item do servidor presente na tabela
     */
    function updateItemInfoArqServer($dadosServidor){

        $id_item    = htmlspecialchars($dadosServidor['id_item']);
        $nome       = htmlspecialchars($dadosServidor['nome']);
        $descricao  = htmlspecialchars($dadosServidor['descricao']);
        $ativo      = htmlspecialchars($dadosServidor['ativo']);

        $sql = "    UPDATE aplicacoes.govti.SUBITEMS_ARQ_SERVERS SET    ITEM = ?
                                                                        ,DESCRICAO = ?
                                                                        ,ATIVO = ?
                    WHERE   ID = ?
        ";


        $sql_log_item = "    INSERT INTO aplicacoes.govti.SUBITEMS_ARQ_SERVERS_LOG (  OPERACAO
                                                                    ,DATA_OPERACAO
                                                                    ,USUARIO
                                                                    ,CAMPO_ID_SERVIDOR
                                                                    ,CAMPO_ITEM
                                                                    ,CAMPO_DESCRICAO
                                                                    ,CAMPO_ATIVO
                                                                    ,CAMPO_DATA_INSERT
                                                                )

                            SELECT  'ALTERA' AS OPERACAO
                                    ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                    ,'lucas.martins' AS USUARIO
                                    ,ID_SERVIDOR
                                    ,ITEM
                                    ,DESCRICAO
                                    ,ATIVO
                                    ,DATA_INSERT
                            FROM    aplicacoes.govti.SUBITEMS_ARQ_SERVERS
                            WHERE   ID = ?
                        ";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $descricao, $ativo, $id_item));

        $stmt_log = $this->pdo->prepare($sql_log_item);
        $stmt_log->execute(array($id_item));

        return $result;
        
    }


    /**
     * Efetua uma busca na tabela que armazena os sub-items relacionado ao ID do servidor fornecido
     */
    function retornaSubItemsServer($dadosServidor){

        $id_servidor = htmlspecialchars($dadosServidor['id_servidor']);

        $sql = "    SELECT  *
                    FROM    aplicacoes.govti.SUBITEMS_ARQ_SERVERS
                    WHERE   ID_SERVIDOR = ?";

        $stmt = $this->pdo->prepare($sql);                
        $stmt->execute(array($id_servidor));
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}

?>
