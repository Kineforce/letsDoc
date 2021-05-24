<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);


/**
 * Retorna informação dos servidores
 */
function retornaInfoArqServers(){
    require_once('conn.php');

    $sql = "SELECT * FROM DOCSIS.ARQSERVERS;";

    $result = $pdo->query($sql)->fetchAll();

    return $result;

}