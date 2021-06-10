<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);

class JobTrigger_model {

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
    function retornaInfoJobTriggerFiltro($palavraBuscada){

        $palavraBuscada = strtolower($palavraBuscada);

        $search = "%$palavraBuscada%";

        $sql = "    SELECT      DISTINCT JB.*
                    FROM        MAP_JOB_TRIGGER AS JB 
                    WHERE       lower(JB.NOME) LIKE :palavra_buscada
                    OR          lower(JB.DESCRICAO) LIKE :palavra_buscada
                    OR          lower(JB.TABELA) LIKE :palavra_buscada
                    OR          lower(JB.DATABASE) LIKE :palavra_buscada
                
                ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('palavra_buscada' => $search));

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    function buscaDadosJobTrigger(){

        $sql = "    SELECT  * 
                    FROM    MAP_JOB_TRIGGER";

        $result = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function insereDadosJobTrigger($dados_job_trigger){

        $nome = $dados_job_trigger['nome'];
        $descricao = $dados_job_trigger['descricao'];
        $tabela = $dados_job_trigger['tabela'];
        $database = $dados_job_trigger['database'];
        $ativo = $dados_job_trigger['ativo'];

        $sql = "    INSERT INTO MAP_JOB_TRIGGER (NOME, DESCRICAO, ATIVO, TABELA, DATABASE, DATA_INSERT)
                    VALUES  (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $descricao, $ativo, $tabela, $database));
        
        return $result;
        

    }

    function deletaDadosJobTrigger($id_job_trigger){

        $id = $id_job_trigger['id_jobtrigger'];

        $sql = "    DELETE FROM MAP_JOB_TRIGGER
                    WHERE   ID = ?";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($id));

        return $result;

    }

    function updateJobTrigger($dados_job_trigger){

        $id = $dados_job_trigger['id_job_trigger'];
        $nome = $dados_job_trigger['nome'];
        $descricao = $dados_job_trigger['descricao'];
        $tabela = $dados_job_trigger['tabela'];
        $database = $dados_job_trigger['database'];
        $ativo = $dados_job_trigger['ativo'];

        $sql = "    UPDATE MAP_JOB_TRIGGER SET  NOME = ?,
                                                DESCRICAO = ?,
                                                ATIVO = ?,
                                                TABELA = ?,
                                                DATABASE = ?

                    WHERE   ID = ?";

        $stmt = $this->pdo->prepare($sql);                                            
        $result = $stmt->execute(array($nome, $descricao, $ativo, $tabela, $database, $id));
    
        return $result;
    }

}
?>