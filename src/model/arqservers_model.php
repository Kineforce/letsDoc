<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);

/**
 * Retorna informação dos servidores
 */
function retornaInfoArqServers(){
    require_once('conn.php');

    $sql = "SELECT * FROM Aplicacoes.govTi.ARQ_SERVERS;";

    $result = mssql_query($sql);

    return $result;

}


/**
 * Retorna informação dos servidores com um parâmetro de filtro
 */
function retornaInfoArqServerFiltro($palavraBuscada){
    require_once('conn.php');

    $palavraBuscada = strtolower($palavraBuscada);

    $sql = "    SELECT  SRV.*
                FROM    Aplicacoes.govTi.ARQ_SERVERS AS SRV 
                JOIN    Aplicacoes.govTi.SUBITEMS_ARQ_SERVERS SUB ON SUB.ID_SERVIDOR = SRV.ID
                WHERE   lower(SRV.NOME) LIKE '%$palavraBuscada%'
                OR      lower(SRV.OBJETIVO) LIKE '%$palavraBuscada%'
                OR      lower(SRV.LINGUAGEM) LIKE '%$palavraBuscada%'
                OR      lower(SUB.ITEM) LIKE '%$palavraBuscada%'
                OR      lower(SUB.DESCRICAO) LIKE '%$palavraBuscada%'
            
            ";

    $result = mssql_query($sql);

    return $result;

}

/**
 * Adiciona novo registro a respeito de servidor na tabela
 */
function insereInfoArqServer($dadosServidor){
    require_once('conn.php');
    
    $nome       = $dadosServidor['nome'];
    $objetivo   = $dadosServidor['objetivo'];
    $linguagem  = $dadosServidor['linguagem'];
    $ativo      = $dadosServidor['ativo'];

    $sql = "    INSERT INTO Aplicacoes.govTI.ARQ_SERVERS (NOME, OBJETIVO, LINGUAGEM, ATIVO, DATA_INSERT)
                VALUES ('$nome', '$objetivo', '$linguagem', '$ativo', GETDATE())";

    $result = mssql_query($sql);

    return $result;
}

/**
 * Adiciona novo registro a respeito do item de um servidor na tabela
 */
function insereInfoItemArqServer($dadosServidor){
    require_once('conn.php');
    
    $id_servidor     = $dadosServidor['id_servidor'];
    $nome            = $dadosServidor['nome'];
    $descricao       = $dadosServidor['descricao'];
    $ativo           = $dadosServidor['ativo'];

    $sql = "    INSERT INTO Aplicacoes.govTI.SUBITEMS_ARQ_SERVERS (ID_SERVIDOR, ITEM, DESCRICAO, ATIVO, DATA_INSERT)
                VALUES ('$id_servidor', '$nome', '$descricao', '$ativo', GETDATE())";

    $result = mssql_query($sql);

    return $result;
}


/**
 * Delete um registro do servidor presente na tabela
 */
function deletaInfoArqServer($dadosServidor){
    require_once('conn.php');

    $id_servidor = $dadosServidor['id_servidor'];

    $sql = "    DELETE  FROM Aplicacoes.govTI.ARQ_SERVERS
                WHERE   id = '$id_servidor'
            ";

    $result = mssql_query($sql);

    return $result;

}

/**
 * Delete um registro de um subitem de um servidor presente na tabela
 */
function deletaInfoItemArqServer($dadosServidor){
    require_once('conn.php');

    $id_item_servidor = $dadosServidor['id_item_servidor'];

    $sql = "    DELETE  FROM Aplicacoes.govTI.SUBITEMS_ARQ_SERVERS
                WHERE   id = '$id_item_servidor'
            ";

    $result = mssql_query($sql);

    return $result;

}
/**
 * Atualiza um registro do servidor presente na tabela
 */
function updateInfoArqServer($dadosServidor){
    require_once('conn.php');

    $id_servidor = $dadosServidor['id_servidor'];
    $nome = $dadosServidor['nome'];
    $objetivo = $dadosServidor['objetivo'];
    $linguagem = $dadosServidor['linguagem'];
    $ativo = $dadosServidor['ativo'];

    $sql = "    UPDATE Aplicacoes.govTI.ARQ_SERVERS SET  NOME = '$nome'
                                                        ,OBJETIVO = '$objetivo'
                                                        ,LINGUAGEM = '$linguagem'
                                                        ,ATIVO = '$ativo'
                WHERE   ID = '$id_servidor'
    ";

    $result = mssql_query($sql);

    return $result;
    
}

/**
 * Atualiza um registro do item do servidor presente na tabela
 */
function updateItemInfoArqServer($dadosServidor){
    require_once('conn.php');

    $id_item    = $dadosServidor['id_item'];
    $nome       = $dadosServidor['nome'];
    $descricao  = $dadosServidor['descricao'];
    $ativo      = $dadosServidor['ativo'];

    $sql = "    UPDATE Aplicacoes.govTI.SUBITEMS_ARQ_SERVERS SET  ITEM = '$nome'
                                                                ,DESCRICAO = '$descricao'
                                                                ,ATIVO = '$ativo'
                WHERE   ID = '$id_item'
    ";

    $result = mssql_query($sql);

    return $result;
    
}


/**
 * Efetua uma busca na tabela que armazena os sub-items relacionado ao ID do servidor fornecido
 */
function retornaSubItemsServer($dadosServidor){
    require_once('conn.php');

    $id_servidor = $dadosServidor['id_servidor'];

    $sql = "    SELECT  *
                FROM    Aplicacoes.govTI.SUBITEMS_ARQ_SERVERS
                WHERE   ID_SERVIDOR = '$id_servidor'";

    $result = mssql_query($sql);                

    return $result;
}