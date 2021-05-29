<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);

// Inicializa a session
session_start();

// Checa se o usuário está acessando a aplicação pelo GOnline
if(!$_SESSION['login']){
    echo json_encode(array(
        "error" => "Não autorizado!"
    ));
    return;
}

// Validando método que foi requisitado

// Retorna informações na tabela da arquitetura de servidores
if(isset($_GET['retornaInfoServidores'])){

    require_once('../model/arqservers_model.php');

    $dados = retornaInfoArqServers();
    $data_array['dados'] = fetchDataToJsonEncode($dados);
    $data_array['count'] = mssql_num_rows($dados);

    echo json_encode($data_array);
    return;
}

// Retorna informações com filtro da tabela de arquitetura de servidores
if(isset($_GET['retornaDataFiltrada'])){

    require_once('../model/arqservers_model.php');

    $palavraBuscada = htmlspecialchars((isset($_GET['retornaDataFiltrada'])) ? $_GET['retornaDataFiltrada'] : '');

    $dados = retornaInfoArqServerFiltro($palavraBuscada);
    $data_array['dados'] = fetchDataToJsonEncode($dados);
    $data_array['count'] = mssql_num_rows($dados);

    echo json_encode($data_array);
    return;
}

if(isset($_POST['cadastraDadosServidor'])){

    require_once('../model/arqservers_model.php');

    $dadosServidor = $_POST['cadastraDadosServidor'];

    $insert = insereInfoArqServer($dadosServidor);
    
    echo json_encode($insert);
    return;

}

if(isset($_POST['cadastraDadosItemServidor'])){

    require_once('../model/arqservers_model.php');

    $dadosServidor = $_POST['cadastraDadosItemServidor'];

    $insert = insereInfoItemArqServer($dadosServidor);
    
    echo json_encode($insert);
    return;

}

if(isset($_POST['deletaIdServidor'])){

    require_once('../model/arqservers_model.php');

    $dadosServidor = $_POST['deletaIdServidor'];

    $delete = deletaInfoArqServer($dadosServidor);
    
    echo json_encode($insert);
    return;
}

if(isset($_POST['buscaSubItemsServer'])){

    require_once('.../model/arqservers_model.php');

    $dadosServidor = $_POST['buscaSubItemsServer'];

    $delete_item = deletaInfoItemArqServer($dadosServidor);

    echo json_encode($delete_item);
    return;
}

if(isset($_POST['updateIdServidor'])){

    require_once('../model/arqservers_model.php');

    $dadosServidor = $_POST['updateIdServidor'];

    $delete = updateInfoArqServer($dadosServidor);
    
    echo json_encode($delete);
    return;
}


if(isset($_POST['updateIdServidorSubItem'])){

    require_once('../model/arqservers_model.php');

    $dadosServidor = $_POST['updateIdServidorSubItem'];

    $delete = updateItemInfoArqServer($dadosServidor);
    
    echo json_encode($delete);
    return;
}


if(isset($_GET['buscaSubItemsServer'])){

    require_once('../model/arqservers_model.php');

    $dadosServidor = $_GET['buscaSubItemsServer'];

    $dados = retornaSubItemsServer($dadosServidor);
    $data_array['dados'] = fetchDataToJsonEncode($dados);
    $data_array['count'] = mssql_num_rows($dados);

    echo json_encode($data_array);
    return;

}

/**
 * Retorna a data formatada para retornar ao front-end pelo json_encode
 */
function fetchDataToJsonEncode($dados){
    $data_array = array();

    if (mssql_num_rows($dados) != 0){
        while ($linha = mssql_fetch_array($dados)){
            if(!empty($linha)){
                $data_array[] = $linha;
            }
        }
    }
    return $data_array;
}