<?php

$_SESSION['usuariovalidado'] = 1;

// Checa se o usuário está acessando a aplicação pelo GOnline
if(!isset($_SESSION['usuariovalidado'])){
    echo json_encode([
        "error" => "Não autorizado!"
    ]);
    return;
}

// Validando método que foi requisitado

if($_GET['retornaInfoServidores']){

    require_once('../model/api_model.php');

    $dados = retornaInfoArqServers();
    echo json_encode($dados);
    return;
}

if($_GET['retornaDataFiltrada']){

    require_once('../model/api_model.php');

    $palavraBuscada = htmlspecialchars((isset($_GET['retornaDataFiltrada'])) ? $_GET['retornaDataFiltrada'] : '');

    $dados = retornaInfoArqServerFiltro($palavraBuscada);
    
    echo json_encode($dados);
    return;
}

