<?php

require_once ('../helper/fetch_json_helper.php');

class ArqServers_controller extends Helpers{

    public $model_functions;

    function __construct(){
        require('../model/arqservers_model.php');

        $this->model_functions = new ArqServers_Model();

    }

    function retornaInfoServidores(){

        $dados = $this->model_functions->retornaInfoArqServers();
        $data_array['dados'] = $this->fetchDataToJsonEncode($dados);
    
        echo json_encode($data_array);

    }

    function retornaDataFiltrada(){

        $palavraBuscada = htmlspecialchars((isset($_GET['retornaDataFiltrada'])) ? $_GET['retornaDataFiltrada'] : '');

        $dados = $this->model_functions->retornaInfoArqServerFiltro($palavraBuscada);
        $data_array['dados'] = $this->fetchDataToJsonEncode($dados);
    
        echo json_encode($data_array);
    }

    function cadastraDadosServidor(){

        $dadosServidor = $_POST['cadastraDadosServidor'];

        $insert = $this->model_functions->insereInfoArqServer($dadosServidor);
        
        echo json_encode($insert);
    }

    function cadastraDadosItemServidor(){
        $dadosServidor = $_POST['cadastraDadosItemServidor'];

        $insert = $this->model_functions->insereInfoItemArqServer($dadosServidor);
    
        echo json_encode($insert);
    }

    function deletaIdServidor(){

        $dadosServidor = $_POST['deletaIdServidor'];

        $delete = $this->model_functions->deletaInfoArqServer($dadosServidor);
        
        echo json_encode($delete);

    }

    function deletaInfoItemArqServer(){
        $dadosServidor = $_POST['deletaInfoItemArqServer'];

        $delete_item = $this->model_functions->deletaInfoItemArqServer($dadosServidor);

        echo json_encode($delete_item);
    }

    function updateIdServidor(){

        $dadosServidor = $_POST['updateIdServidor'];

        $delete = $this->model_functions->updateInfoArqServer($dadosServidor);
    
        echo json_encode($delete);
    }

    function updateIdServidorSubItem(){
        $dadosServidor = $_POST['updateIdServidorSubItem'];

        $delete = $this->model_functions->updateItemInfoArqServer($dadosServidor);
    
        echo json_encode($delete);
    }

    function buscaSubItemsServidor(){
        $dadosServidor = $_GET['buscaSubItemsServer'];

        $dados = $this->model_functions->retornaSubItemsServer($dadosServidor);
        $data_array['dados'] = $this->fetchDataToJsonEncode($dados);

        echo json_encode($data_array);

    }


}



?>