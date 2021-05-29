<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);

// Importa o controlador para ter o método chamado de acordo com o parâmetro vindo no request
require ('../controller/arqservers.php');
$call = new ArqServers_controller();

// Arquivo destinado para as rotas da aplicação

if(isset($_GET['retornaInfoServidores'])){

    $call->retornaInfoServidores();
    return;

}

if(isset($_GET['retornaDataFiltrada'])){

    $call->retornaDataFiltrada();
    return;
}

if(isset($_POST['cadastraDadosServidor'])){

    $call->cadastraDadosServidor();
    return;

}

if(isset($_POST['cadastraDadosItemServidor'])){

    $call->cadastraDadosItemServidor();
    return;

}

if(isset($_POST['deletaIdServidor'])){

    $call->deletaIdServidor();
    return;
}


if(isset($_POST['deletaInfoItemArqServer'])){

    $call->deletaInfoItemArqServer();
    return;
}

if(isset($_POST['updateIdServidor'])){
    
    $call->updateIdServidor();
    return;
}


if(isset($_POST['updateIdServidorSubItem'])){

    $call->updateIdServidorSubItem();
    return;
}


if(isset($_GET['buscaSubItemsServer'])){

    $call->buscaSubItemsServidor();
    return;

}

