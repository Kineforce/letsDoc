<?php
require_once('../session_auth/session.php');

class JobTrigger_model
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
    function retornaTotalJobTrigger()
    {

        $sql_count_total = "    SELECT      COUNT(*) AS TOTAL
                                FROM        Aplicacoes.GovTi.MAP_JOB_TRIGGER
                            ";

        $stmt_count_total = $this->pdo->query($sql_count_total)->fetchAll(PDO::FETCH_ASSOC);

        return $stmt_count_total;
    }

    /**
     * Retorna o total de registros da tabela
     */
    function retornaExcelJobTrigger()
    {

        $sql_count_total = "    SELECT      *
                                FROM        Aplicacoes.GovTi.MAP_JOB_TRIGGER
                            ";

        $stmt_count_total = $this->pdo->query($sql_count_total)->fetchAll(PDO::FETCH_ASSOC);

        return $stmt_count_total;
    }

    /**
     * Retorna informação com um parâmetro de filtro
     */
    function retornaInfoJobTriggerFiltro($palavraBuscada, $limit)
    {

        $palavraBuscada = strtolower($palavraBuscada);

        $search = "%$palavraBuscada%";

        $sql = "    SELECT      DISTINCT JB.*
                    FROM        Aplicacoes.GovTi.MAP_JOB_TRIGGER AS JB 
                    WHERE       lower(JB.NOME) LIKE :palavra_buscada
                    OR          lower(JB.DESCRICAO) LIKE :palavra_buscada
                    OR          lower(JB.TABELA) LIKE :palavra_buscada
                    OR          lower(JB.[DATABASE]) LIKE :palavra_buscada
                    $limit
                ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('palavra_buscada' => $search));

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function insereDadosJobTrigger($dados_job_trigger)
    {

        $nome           =  utf8_decode($dados_job_trigger['nome']);
        $descricao      =  utf8_decode($dados_job_trigger['descricao']);
        $tabela         =  utf8_decode($dados_job_trigger['tabela']);
        $database       =  utf8_decode($dados_job_trigger['database']);
        $ativo          =  utf8_decode($dados_job_trigger['ativo']);

        $sql = "    INSERT INTO Aplicacoes.GovTi.MAP_JOB_TRIGGER (NOME, DESCRICAO, ATIVO, TABELA, [DATABASE], DATA_INSERT)
                    VALUES  (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

        $sql_log = "    INSERT INTO Aplicacoes.GovTi.MAP_JOB_TRIGGER_LOG (
                                                             OPERACAO
                                                            ,DATA_OPERACAO
                                                            ,USUARIO
                                                            ,CAMPO_NOME
                                                            ,CAMPO_DESCRICAO
                                                            ,CAMPO_ATIVO
                                                            ,CAMPO_TABELA
                                                            ,CAMPO_DATABASE
                                                            ,CAMPO_DATA_INSERT
                                                        )
        
                        SELECT  'CADASTRA' AS OPERACAO
                                ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                ,? AS USUARIO
                                ,NOME
                                ,DESCRICAO
                                ,ATIVO
                                ,TABELA
                                ,[DATABASE]
                                ,DATA_INSERT
                        FROM    Aplicacoes.GovTi.MAP_JOB_TRIGGER
                        WHERE   ID = ?
                        
        ";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $descricao, $ativo, $tabela, $database));

        $stmt_log = $this->pdo->prepare($sql_log);

        $ultimo_id_tabela = $this->pdo->lastInsertId();

        $stmt_log->execute(array($_SESSION['login'], $ultimo_id_tabela));

        return $result;
    }

    function deletaDadosJobTrigger($id_job_trigger)
    {

        $id = $id_job_trigger['id_jobtrigger'];

        $sql = "    DELETE FROM Aplicacoes.GovTi.MAP_JOB_TRIGGER
                    WHERE   ID = ?";

        $sql_log = "    INSERT INTO Aplicacoes.GovTi.MAP_JOB_TRIGGER_LOG (
                                                             OPERACAO
                                                            ,DATA_OPERACAO
                                                            ,USUARIO
                                                            ,CAMPO_NOME
                                                            ,CAMPO_DESCRICAO
                                                            ,CAMPO_ATIVO
                                                            ,CAMPO_TABELA
                                                            ,CAMPO_DATABASE
                                                            ,CAMPO_DATA_INSERT
                                                        )
        
                        SELECT  'REMOVE' AS OPERACAO
                                ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                ,? AS USUARIO
                                ,NOME
                                ,DESCRICAO
                                ,ATIVO
                                ,TABELA
                                ,[DATABASE]
                                ,DATA_INSERT
                        FROM    Aplicacoes.GovTi.MAP_JOB_TRIGGER
                        WHERE   ID = ?
                        
        ";

        $stmt_log = $this->pdo->prepare($sql_log);
        $stmt_log->execute(array($_SESSION['login'], $id));

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($id));

        return $result;
    }

    function updateJobTrigger($dados_job_trigger)
    {

        $id             =  utf8_decode($dados_job_trigger['id_job_trigger']);
        $nome           =  utf8_decode($dados_job_trigger['nome']);
        $descricao      =  utf8_decode($dados_job_trigger['descricao']);
        $tabela         =  utf8_decode($dados_job_trigger['tabela']);
        $database       =  utf8_decode($dados_job_trigger['database']);
        $ativo          =  utf8_decode($dados_job_trigger['ativo']);

        $sql = "    UPDATE Aplicacoes.GovTi.MAP_JOB_TRIGGER SET  NOME = ?,
                                                DESCRICAO = ?,
                                                ATIVO = ?,
                                                TABELA = ?,
                                                [DATABASE] = ?

                    WHERE   ID = ?";

        $sql_log = "    INSERT INTO Aplicacoes.GovTi.MAP_JOB_TRIGGER_LOG (
                                                             OPERACAO
                                                            ,DATA_OPERACAO
                                                            ,USUARIO
                                                            ,CAMPO_NOME
                                                            ,CAMPO_DESCRICAO
                                                            ,CAMPO_ATIVO
                                                            ,CAMPO_TABELA
                                                            ,CAMPO_DATABASE
                                                            ,CAMPO_DATA_INSERT
                                                        )
        
                        SELECT  'ALTERA' AS OPERACAO
                                ,CURRENT_TIMESTAMP AS DATA_OPERACAO
                                ,? AS USUARIO
                                ,NOME
                                ,DESCRICAO
                                ,ATIVO
                                ,TABELA
                                ,[DATABASE]
                                ,DATA_INSERT
                        FROM    Aplicacoes.GovTi.MAP_JOB_TRIGGER
                        WHERE   ID = ?
                        
        ";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $descricao, $ativo, $tabela, $database, $id));

        $stmt_log = $this->pdo->prepare($sql_log);
        $stmt_log->execute(array($_SESSION['login'], $id));

        return $result;
    }
}
