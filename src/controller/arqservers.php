<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', 1);

// // Inicializa a session
// session_start();

// // Checa se o usuário está acessando a aplicação pelo GOnline
// if(!$_SESSION['login']){
//     echo json_encode(array(
//         "error" => "Não autorizado!"
//     ));
//     return;
// }

require('../model/arqservers_model.php');
$model_functions = new ArqServers_Model();

// Validando método que foi requisitado

// Retorna informações na tabela da arquitetura de servidores
if(isset($_GET['retornaInfoServidores'])){

    $dados = $model_functions->retornaInfoArqServers();
    $data_array['dados'] = fetchDataToJsonEncode($dados);

    echo json_encode($data_array);
    return;

}

// Retorna informações com filtro da tabela de arquitetura de servidores
if(isset($_GET['retornaDataFiltrada'])){

    $palavraBuscada = htmlspecialchars((isset($_GET['retornaDataFiltrada'])) ? $_GET['retornaDataFiltrada'] : '');

    $dados = $model_functions->retornaInfoArqServerFiltro($palavraBuscada);
    $data_array['dados'] = fetchDataToJsonEncode($dados);

    echo json_encode($data_array);
    return;
}

if(isset($_POST['cadastraDadosServidor'])){

    $dadosServidor = $_POST['cadastraDadosServidor'];

    $insert = $model_functions->insereInfoArqServer($dadosServidor);
    
    echo json_encode($insert);
    return;

}

if(isset($_POST['cadastraDadosItemServidor'])){

    $dadosServidor = $_POST['cadastraDadosItemServidor'];

    $insert = $model_functions->insereInfoItemArqServer($dadosServidor);
    
    echo json_encode($insert);
    return;

}

if(isset($_POST['deletaIdServidor'])){

    $dadosServidor = $_POST['deletaIdServidor'];

    $delete = $model_functions->deletaInfoArqServer($dadosServidor);
    
    echo json_encode($insert);
    return;
}


if(isset($_POST['deletaInfoItemArqServer'])){

    $dadosServidor = $_POST['deletaInfoItemArqServer'];

    $delete_item = $model_functions->deletaInfoItemArqServer($dadosServidor);

    echo json_encode($delete_item);
    return;
}

if(isset($_POST['updateIdServidor'])){

    $dadosServidor = $_POST['updateIdServidor'];

    $delete = $model_functions->updateInfoArqServer($dadosServidor);
    
    echo json_encode($delete);
    return;
}


if(isset($_POST['updateIdServidorSubItem'])){

    $dadosServidor = $_POST['updateIdServidorSubItem'];

    $delete = $model_functions->updateItemInfoArqServer($dadosServidor);
    
    echo json_encode($delete);
    return;
}


if(isset($_GET['buscaSubItemsServer'])){

    $dadosServidor = $_GET['buscaSubItemsServer'];

    $dados = $model_functions->retornaSubItemsServer($dadosServidor);
    $data_array['dados'] = fetchDataToJsonEncode($dados);

    echo json_encode($data_array);
    return;

}

/**
 * Retorna a data formatada para retornar ao front-end pelo json_encode
 */
function fetchDataToJsonEncode($dados){
    $data = [];

    while ($row = $dados->fetch(\PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    return $data;
}