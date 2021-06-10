<?php

require_once ('../helper/general_helpers.php');

class MapSistemas_controller extends Helpers{

    function __construct(){
        require('../model/mapsistemas_model.php');

        $this->model_functions = new MapSistemas_model();
    }


    function retornaDataFiltradaMapSistemas(){

        $palavraBuscada = htmlspecialchars((isset($_GET['retornaDataFiltradaMapSistemas'])) ? $_GET['retornaDataFiltradaMapSistemas'] : '');

        $data_array['dados'] = $this->model_functions->retornaInfoMapSistemasFiltro($palavraBuscada);
    
        echo json_encode($data_array);
    }


    function retornaDadosMapSistemas(){
        
        $result['dados'] = $this->model_functions->buscaDadosMapSistemas();
        echo json_encode($result);

    }

    function cadastraDadosMapSistemas(){

        $dados_map_sistemas = $_POST['cadastraDadosMapSistemas'];

        $result = $this->model_functions->insereDadosMapSistemas($dados_map_sistemas);
        echo json_encode($result);  

    }

    function deletaRegistroMapSistemas(){

        $id_map_sistemas = $_POST['deletaMapSistemas'];

        $result = $this->model_functions->deletaDadosMapSistemas($id_map_sistemas);
        echo json_encode($result);

    }

    function updateMapSistemas(){

        $dados_map_sistemas = $_POST['updateMapSistemas'];

        $result = $this->model_functions->updateMapSistemas($dados_map_sistemas);
        echo json_encode($result);

    }

}


?>