<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);

// Importa o controlador para ter o método chamado de acordo com o parâmetro vindo no request
require ('../controller/arqservers.php');
require ('../controller/arqdatabase.php');

$call_arq_database = new ArqDatabase_controller();
$call_arq_servers = new ArqServers_controller();

/******** ARQUITETURA DE SERVIDORES ********/

if(isset($_GET['retornaInfoServidores'])){

    $call_arq_servers->retornaInfoServidores();
    return;

}

if(isset($_GET['retornaDataFiltrada'])){

    $call_arq_servers->retornaDataFiltrada();
    return;
}

if(isset($_POST['cadastraDadosServidor'])){

    $call_arq_servers->cadastraDadosServidor();
    return;

}

if(isset($_POST['cadastraDadosItemServidor'])){

    $call_arq_servers->cadastraDadosItemServidor();
    return;

}

if(isset($_POST['deletaIdServidor'])){

    $call_arq_servers->deletaIdServidor();
    return;
}


if(isset($_POST['deletaInfoItemArqServer'])){

    $call_arq_servers->deletaInfoItemArqServer();
    return;
}

if(isset($_POST['updateIdServidor'])){
    
    $call_arq_servers->updateIdServidor();
    return;
}


if(isset($_POST['updateIdServidorSubItem'])){

    $call_arq_servers->updateIdServidorSubItem();
    return;
}


if(isset($_GET['buscaSubItemsServer'])){

    $call_arq_servers->buscaSubItemsServidor();
    return;

}


/******** ARQUITETURA DE BANCO DE DADOS ********/

if(isset($_GET['retornaInfoDatabase'])){

    $call_arq_database->retornaInfoDatabase();
    return;

}

if(isset($_POST['cadastraDadosDatabase'])){

    $call_arq_database->cadastraInfoDatabase();
    return;

}

if(isset($_POST['deletaIdDatabase'])){

    $call_arq_database->deletaIdDatabase();
    return;
}

if(isset($_POST['updateIdDatabase'])){

    $call_arq_database->updateInfoDatabase();
    return;

}

if(isset($_GET['buscaSubItemsDatabase'])){

    $call_arq_database->buscaSubItemsDatabase();
    return;

}

if(isset($_POST['cadastraDadosItemDatabase'])){

    $call_arq_database->cadastraItemDatabase();
    return;

}

if(isset($_POST['deletaInfoItemDatabase'])){

    $call_arq_database->deletaSubItemDatabase();
    return;

}

if(isset($_POST['updateIdDatabaseSubItem'])){

    $call_arq_database->updateDatabaseSubitem();
    return;

}


if(isset($_GET['retornaDataFiltradaDatabase'])){

    $call_arq_database->retornaDataFiltradaDatabase();
    return;
}