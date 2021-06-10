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
     * Retorna informação dos servidores com um parâmetro de filtro
     */
    function retornaInfoMapSistemasFiltro($palavraBuscada){

        $palavraBuscada = strtolower($palavraBuscada);

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

    function insereDadosMapSistemas($dados_map_sistemas){

        $nome = $dados_map_sistemas['nome'];
        $descricao = $dados_map_sistemas['descricao'];
        $anexo = $dados_map_sistemas['anexo'];
        $database = $dados_map_sistemas['database'];
        $servidor = $dados_map_sistemas['servidor'];
        $setor = $dados_map_sistemas['setor'];
        $ocorrencia = $dados_map_sistemas['ocorrencia'];
        $ativo = $dados_map_sistemas['ativo'];

        $sql = "    INSERT INTO MAP_SISTEMAS (NOME, DESCRICAO, ANEXO, [DATABASE], SERVIDOR, SETOR, OCORRENCIA, ATIVO, DATA_INSERT)
                    VALUES  (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($nome, $descricao, $anexo, $database, $servidor, $setor, $ocorrencia, $ativo));
        
        return $result;
        

    }

    function deletaDadosMapSistemas($id_map_sistemas){

        $id = $id_map_sistemas['id_map_sistemas'];

        $sql = "    DELETE FROM MAP_SISTEMAS
                    WHERE   ID = ?";

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(array($id));

        return $result;

    }

    function updateMapSistemas($dados_map_sistemas){

        $id = $dados_map_sistemas['id_map_sistemas'];
        $nome = $dados_map_sistemas['nome'];
        $descricao = $dados_map_sistemas['descricao'];
        $anexo = $dados_map_sistemas['anexo'];
        $database = $dados_map_sistemas['database'];
        $servidor = $dados_map_sistemas['servidor'];
        $setor = $dados_map_sistemas['setor'];
        $ocorrencia = $dados_map_sistemas['ocorrencia'];
        $ativo = $dados_map_sistemas['ativo'];
        

        $sql = "    UPDATE MAP_SISTEMAS SET     NOME = ?,
                                                DESCRICAO = ?,
                                                ANEXO = ?,
                                                [DATABASE] = ?,
                                                SERVIDOR = ?,
                                                SETOR = ?,
                                                OCORRENCIA = ?,
                                                ATIVO = ?

                    WHERE   ID = ?";

        $stmt = $this->pdo->prepare($sql);                                            
        $result = $stmt->execute(array($nome, $descricao, $anexo, $database, $servidor, $setor, $ocorrencia, $ativo, $id));
    
        return $result;
    }

}
?>