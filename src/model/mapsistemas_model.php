<?php
require_once('../session_auth/session.php');

class MapSistemas_model
{

    private $pdo;

    function __construct()
    {
        // Fazendo conexão com o banco de dados
        require_once('conn.php');
        $this->pdo = new ConectaLyceumPDO();
        $this->pdo = $this->pdo->connect();
    }
    /**
     * Retorna o total de registros da tabela
     */
    function retornaTotalMapSistemas()
    {

        $sql_count_total = "    SELECT      COUNT(*) AS TOTAL
                                FROM        Aplicacoes.GovTi.MAP_SISTEMAS
                            ";

        $stmt_count_total = $this->pdo->query($sql_count_total)->fetchAll(PDO::FETCH_ASSOC);

        return $stmt_count_total;
    }

    /**
     * Retorna o total de registros da tabela
     */
    function retornaExcelMapSistemas()
    {

        $sql_count_total = "    SELECT      *
                                FROM        Aplicacoes.GovTi.MAP_SISTEMAS
                            ";

        $stmt_count_total = $this->pdo->query($sql_count_total)->fetchAll(PDO::FETCH_ASSOC);

        return $stmt_count_total;
    }
    /**
     * Retorna informação com um parâmetro de filtro
     */
    function retornaInfoMapSistemasFiltro($palavraBuscada, $limit)
    {

        $palavraBuscada = strtolower($palavraBuscada);

        $search = "%$palavraBuscada%";

        $sql = "    SELECT      DISTINCT MS.*
                    FROM        Aplicacoes.GovTi.MAP_SISTEMAS AS MS 
                    WHERE       lower(MS.NOME) LIKE :palavra_buscada
                    OR          lower(MS.DESCRICAO) LIKE :palavra_buscada
                    OR          lower(MS.ANEXO) LIKE :palavra_buscada
                    OR          lower(MS.[DATABASE]) LIKE :palavra_buscada
                    OR          lower(MS.SERVIDOR) LIKE :palavra_buscada
                    OR          lower(MS.SETOR) LIKE :palavra_buscada
                    OR          lower(MS.OCORRENCIA) LIKE :palavra_buscada       
                    $limit         
                ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('palavra_buscada' => $search));

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    function buscaAnexoAtualMapSistemas($id)
    {

        $sql = "    SELECT  ANEXO
                    FROM    Aplicacoes.GovTi.MAP_SISTEMAS
                    WHERE   ID = ? ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($id));

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function insereDadosMapSistemas($dados_map_sistemas, $nome_anexo)
    {

        $nome           =   utf8_decode($dados_map_sistemas['nome']);
        $descricao      =   utf8_decode($dados_map_sistemas['descricao']);
        $database       =   utf8_decode($dados_map_sistemas['database']);
        $servidor       =   utf8_decode($dados_map_sistemas['servidor']);
        $setor          =   utf8_decode($dados_map_sistemas['setor']);
        $ocorrencia     =   utf8_decode($dados_map_sistemas['ocorrencia']);
        $ativo          =   utf8_decode($dados_map_sistemas['ativo']);
        $nome_anexo     =   utf8_decode((is_null($nome_anexo) ? '' : $nome_anexo));

        $sql = "    INSERT INTO Aplicacoes.GovTi.MAP_SISTEMAS (NOME, DESCRICAO, ANEXO, [DATABASE], SERVIDOR, SETOR, OCORRENCIA, ATIVO, DATA_INSERT)
                    VALUES  (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

        $sql_log = "    INSERT INTO Aplicacoes.GovTi.MAP_SISTEMAS_LOG (
                                                         OPERACAO
                                                        ,DATA_OPERACAO
                                                        ,USUARIO
                                                        ,CAMPO_NOME
                                                        ,CAMPO_DESCRICAO
                                                        ,CAMPO_ANEXO
                                                        ,CAMPO_DATABASE
                                                        ,CAMPO_SERVIDOR
                                                        ,CAMPO_SETOR
                                                        ,CAMPO_OCORRENCIA
                                                        ,CAMPO_ATIVO                                                                                                                        
                                                        ,CAMPO_DATA_INSERT
                                                    )
        
                        SELECT  'CADASTRA' AS OPERACAO
                                ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                ,? AS USUARIO
                                ,NOME
                                ,DESCRICAO
                                ,ANEXO
                                ,[DATABASE]
                                ,SERVIDOR
                                ,SETOR
                                ,OCORRENCIA
                                ,ATIVO
                                ,DATA_INSERT
                        FROM    Aplicacoes.GovTi.MAP_SISTEMAS
                        WHERE   ID = ?
                        
        ";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $descricao, $nome_anexo, $database, $servidor, $setor, $ocorrencia, $ativo));

        $stmt_log = $this->pdo->prepare($sql_log);

        $ultimo_id_tabela = $this->pdo->lastInsertId();

        $stmt_log->execute(array($_SESSION['login'], $ultimo_id_tabela));

        return $result;
    }

    function deletaDadosMapSistemas($id_map_sistemas)
    {

        $id = $id_map_sistemas['id_map_sistemas'];

        $sql = "    DELETE FROM Aplicacoes.GovTi.MAP_SISTEMAS
                    WHERE   ID = ?";

        $sql_log = "    INSERT INTO Aplicacoes.GovTi.MAP_SISTEMAS_LOG (
                                                         OPERACAO
                                                        ,DATA_OPERACAO
                                                        ,USUARIO
                                                        ,CAMPO_NOME
                                                        ,CAMPO_DESCRICAO
                                                        ,CAMPO_ANEXO
                                                        ,CAMPO_DATABASE
                                                        ,CAMPO_SERVIDOR
                                                        ,CAMPO_SETOR
                                                        ,CAMPO_OCORRENCIA
                                                        ,CAMPO_ATIVO                                                                                                                        
                                                        ,CAMPO_DATA_INSERT
                                                    )
        
                        SELECT  'REMOVE' AS OPERACAO
                                ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                ,? AS USUARIO
                                ,NOME
                                ,DESCRICAO
                                ,ANEXO
                                ,[DATABASE]
                                ,SERVIDOR
                                ,SETOR
                                ,OCORRENCIA
                                ,ATIVO
                                ,DATA_INSERT
                        FROM    Aplicacoes.GovTi.MAP_SISTEMAS
                        WHERE   ID = ?
                        
        ";

        $stmt_log = $this->pdo->prepare($sql_log);
        $result_log = $stmt_log->execute(array($_SESSION['login'], $id));

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($id));

        return $result_log;
    }

    function updateMapSistemas($dados_map_sistemas_update, $nome_anexo)
    {

        $id             =    utf8_decode($dados_map_sistemas_update['id_map_sistemas']);
        $nome           =    utf8_decode($dados_map_sistemas_update['nome']);
        $descricao      =    utf8_decode($dados_map_sistemas_update['descricao']);
        $database       =    utf8_decode($dados_map_sistemas_update['database']);
        $servidor       =    utf8_decode($dados_map_sistemas_update['servidor']);
        $setor          =    utf8_decode($dados_map_sistemas_update['setor']);
        $ocorrencia     =    utf8_decode($dados_map_sistemas_update['ocorrencia']);
        $ativo          =    utf8_decode($dados_map_sistemas_update['ativo']);

        $controla = true;
        $result = "";

        if (!empty($nome_anexo)) {


            $sql_update = "    UPDATE Aplicacoes.GovTi.MAP_SISTEMAS SET     NOME = ?,
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

        if ($controla) {

            $sql = "    UPDATE Aplicacoes.GovTi.MAP_SISTEMAS SET NOME = ?,
                                            DESCRICAO = ?,
                                            [DATABASE] = ?,
                                            SERVIDOR = ?,
                                            SETOR = ?,
                                            OCORRENCIA = ?,
                                            ATIVO = ?

            WHERE   ID = ?";

            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute(array($nome, $descricao, $database, $servidor, $setor, $ocorrencia, $ativo, $id));
        }

        $sql_log = "    INSERT INTO Aplicacoes.GovTi.MAP_SISTEMAS_LOG (
                                                         OPERACAO
                                                        ,DATA_OPERACAO
                                                        ,USUARIO
                                                        ,CAMPO_NOME
                                                        ,CAMPO_DESCRICAO
                                                        ,CAMPO_ANEXO
                                                        ,CAMPO_DATABASE
                                                        ,CAMPO_SERVIDOR
                                                        ,CAMPO_SETOR
                                                        ,CAMPO_OCORRENCIA
                                                        ,CAMPO_ATIVO                                                                                                                   
                                                        ,CAMPO_DATA_INSERT
                                                    )
        
                        SELECT  'ALTERA' AS OPERACAO
                                ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                ,? AS USUARIO
                                ,NOME
                                ,DESCRICAO
                                ,ANEXO
                                ,[DATABASE]
                                ,SERVIDOR
                                ,SETOR
                                ,OCORRENCIA
                                ,ATIVO
                                ,DATA_INSERT
                        FROM    Aplicacoes.GovTi.MAP_SISTEMAS
                        WHERE   ID = ?
                        
        ";

        $stmt_log = $this->pdo->prepare($sql_log);
        $stmt_log->execute(array($_SESSION['login'], $id));

        return $result;
    }
}
