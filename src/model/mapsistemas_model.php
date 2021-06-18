<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);

class MapSistemas_model {

    private $pdo;

    function __construct(){
        // Fazendo conexão com o banco de dados
        require_once('conn.php');
        $this->pdo = new SQliteConnection();
        $this->pdo = $this->pdo->connect();

    }

         /**
     * Retorna informação com um parâmetro de filtro
     */
    function retornaInfoMapSistemasFiltro($palavraBuscada){

        $palavraBuscada = htmlspecialchars(strtolower($palavraBuscada));

        $search = "%$palavraBuscada%";

        $sql = "    SELECT      DISTINCT MS.*
                    FROM        MAP_SISTEMAS AS MS 
                    WHERE       lower(MS.NOME) LIKE :palavra_buscada
                    OR          lower(MS.DESCRICAO) LIKE :palavra_buscada
                    OR          lower(MS.ANEXO) LIKE :palavra_buscada
                    OR          lower(MS.DATABASE) LIKE :palavra_buscada
                    OR          lower(MS.SERVIDOR) LIKE :palavra_buscada
                    OR          lower(MS.SETOR) LIKE :palavra_buscada
                    OR          lower(MS.OCORRENCIA) LIKE :palavra_buscada
                
                ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('palavra_buscada' => $search));

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    function buscaDadosMapSistemas(){

        $sql = "    SELECT  * 
                    FROM    MAP_SISTEMAS";

        $result = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function buscaAnexoAtualMapSistemas($id){

        $sql = "    SELECT  ANEXO
                    FROM    MAP_SISTEMAS
                    WHERE   ID = ? ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(htmlspecialchars($id)));
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }

    function insereDadosMapSistemas($dados_map_sistemas, $nome_anexo){

        $nome = htmlspecialchars($dados_map_sistemas['nome']);
        $descricao = htmlspecialchars($dados_map_sistemas['descricao']);
        $database = htmlspecialchars($dados_map_sistemas['database']);
        $servidor = htmlspecialchars($dados_map_sistemas['servidor']);
        $setor = htmlspecialchars($dados_map_sistemas['setor']);
        $ocorrencia = htmlspecialchars($dados_map_sistemas['ocorrencia']);
        $ativo = htmlspecialchars($dados_map_sistemas['ativo']);
        $nome_anexo = htmlspecialchars( (is_null($nome_anexo) ? '': $nome_anexo) );

        $sql = "    INSERT INTO MAP_SISTEMAS (NOME, DESCRICAO, ANEXO, [DATABASE], SERVIDOR, SETOR, OCORRENCIA, ATIVO, DATA_INSERT)
                    VALUES  (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

        $sql_log = "    INSERT INTO MAP_SISTEMAS_LOG (
                                                         OPERACAO
                                                        ,DATA_OPERACAO
                                                        ,USUARIO
                                                        ,NOME
                                                        ,DESCRICAO
                                                        ,ANEXO
                                                        ,[DATABASE]
                                                        ,SERVIDOR
                                                        ,SETOR
                                                        ,OCORRENCIA
                                                        ,ATIVO                                                                                                                        
                                                        ,DATA_INSERT
                                                    )
        
                        SELECT  'CADASTRA' AS OPERACAO
                                ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                ,'lucas.martins' AS USUARIO
                                ,NOME
                                ,DESCRICAO
                                ,ANEXO
                                ,[DATABASE]
                                ,SERVIDOR
                                ,SETOR
                                ,OCORRENCIA
                                ,ATIVO
                                ,DATA_INSERT
                        FROM    MAP_SISTEMAS
                        WHERE   ID = ?
                        
        ";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $descricao, $nome_anexo, $database, $servidor, $setor, $ocorrencia, $ativo));
        
        $stmt_log = $this->pdo->prepare($sql_log);
        $ultimo_registro = $this->pdo->lastInsertId();
        $stmt_log->execute(array($ultimo_registro)); 

        return $result;
        

    }

    function deletaDadosMapSistemas($id_map_sistemas){

        $id = htmlspecialchars($id_map_sistemas['id_map_sistemas']);

        $sql = "    DELETE FROM MAP_SISTEMAS
                    WHERE   ID = ?";

        $sql_log = "    INSERT INTO MAP_SISTEMAS_LOG (
                                                         OPERACAO
                                                        ,DATA_OPERACAO
                                                        ,USUARIO
                                                        ,NOME
                                                        ,DESCRICAO
                                                        ,ANEXO
                                                        ,[DATABASE]
                                                        ,SERVIDOR
                                                        ,SETOR
                                                        ,OCORRENCIA
                                                        ,ATIVO                                                                                                                        
                                                        ,DATA_INSERT
                                                    )
        
                        SELECT  'REMOVE' AS OPERACAO
                                ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                ,'lucas.martins' AS USUARIO
                                ,NOME
                                ,DESCRICAO
                                ,ANEXO
                                ,[DATABASE]
                                ,SERVIDOR
                                ,SETOR
                                ,OCORRENCIA
                                ,ATIVO
                                ,DATA_INSERT
                        FROM    MAP_SISTEMAS
                        WHERE   ID = ?
                        
        ";

        $stmt_log = $this->pdo->prepare($sql_log);
        $stmt_log->execute(array($id));

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($id));

        return $result;

    }

    function updateMapSistemas($dados_map_sistemas_update, $nome_anexo){

        $id = htmlspecialchars($dados_map_sistemas_update['id_map_sistemas']);
        $nome = htmlspecialchars($dados_map_sistemas_update['nome']);
        $descricao = htmlspecialchars($dados_map_sistemas_update['descricao']);
        $database = htmlspecialchars($dados_map_sistemas_update['database']);
        $servidor = htmlspecialchars($dados_map_sistemas_update['servidor']);
        $setor = htmlspecialchars($dados_map_sistemas_update['setor']);
        $ocorrencia = htmlspecialchars($dados_map_sistemas_update['ocorencia']);
        $ativo = htmlspecialchars($dados_map_sistemas_update['ativo']);
        
        $controla = true;
        $result = "";

        if (!empty($nome_anexo)){


            $sql_update = "    UPDATE MAP_SISTEMAS SET     NOME = ?,
                                                            DESCRICAO = ?,
                                                            ANEXO = ?,
                                                            [DATABASE] = ?,
                                                            SERVIDOR = ?,
                                                            SETOR = ?,
                                                            OCORRENCIA = ?,
                                                            ATIVO = ?

            WHERE   ID = ?";

            $stmt_update = $this->pdo->prepare($sql_update);                                            
            $result = $stmt_update->execute(array($nome, $descricao, $nome_anexo, $database, $servidor, $setor, $ocorrencia, $ativo, $id));

            $controla = false;
        }

        if ($controla){

            $sql = "    UPDATE MAP_SISTEMAS SET NOME = ?,
                                            DESCRICAO = ?,
                                            [DATABASE] = ?,
                                            SERVIDOR = ?,
                                            SETOR = ?,
                                            OCORRENCIA = ?,
                                            ATIVO = ?

            WHERE   ID = ?";

            $stmt= $this->pdo->prepare($sql);                                            
            $result = $stmt->execute(array($nome, $descricao, $database, $servidor, $setor, $ocorrencia, $ativo, $id));

        }

        $sql_log = "    INSERT INTO MAP_SISTEMAS_LOG (
                                                         OPERACAO
                                                        ,DATA_OPERACAO
                                                        ,USUARIO
                                                        ,NOME
                                                        ,DESCRICAO
                                                        ,ANEXO
                                                        ,[DATABASE]
                                                        ,SERVIDOR
                                                        ,SETOR
                                                        ,OCORRENCIA
                                                        ,ATIVO                                                                                                                        
                                                        ,DATA_INSERT
                                                    )
        
                        SELECT  'ALTERA' AS OPERACAO
                                ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                ,'lucas.martins' AS USUARIO
                                ,NOME
                                ,DESCRICAO
                                ,ANEXO
                                ,[DATABASE]
                                ,SERVIDOR
                                ,SETOR
                                ,OCORRENCIA
                                ,ATIVO
                                ,DATA_INSERT
                        FROM    MAP_SISTEMAS
                        WHERE   ID = ?
                        
        ";

        $stmt_log = $this->pdo->prepare($sql_log);
        $stmt_log->execute(array($id));

        return $result;

    }

}
?>