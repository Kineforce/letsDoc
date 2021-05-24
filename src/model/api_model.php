<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);


/**
 * Retorna informação dos servidores
 */
function retornaInfoArqServers(){
    require_once('conn.php');

    $sql = "    SELECT  * 
                FROM    DOCSIS.ARQSERVERS
                
            ";

    $result = $pdo->query($sql)->fetchAll();

    return $result;

}

function retornaInfoArqServerFiltro($palavraBuscada){
    require_once('conn.php');

    $palavraBuscada = strtolower($palavraBuscada);

    $sql = "    SELECT  *
                FROM    DOCSIS.ARQSERVERS
                WHERE   lower(NOME) LIKE '%$palavraBuscada%'
                OR      lower(OBJETIVO) LIKE '%$palavraBuscada%'
                OR      lower(LINGUAGEM) LIKE '%$palavraBuscada%'
                
            
            ";

    $result = $pdo->query($sql)->fetchAll();

    return $result;

}