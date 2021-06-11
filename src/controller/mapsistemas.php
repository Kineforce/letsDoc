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

        $nome_anexo = "";
        $dados_map_sistemas = $_POST;

        // Verifica se existe algum anexo enviado junto com o post
        if (!empty($_FILES)){
            $nome_anexo = $_FILES['anexo']['name'];
            $momento_atual = date("Y_m_d_H_i_s");
            $novo_nome_arquivo = "$momento_atual";
            $caminho_temp_anexo = $_FILES['anexo']['tmp_name'];
            $caminho_salva_anexo = "../uploads_anexos/" . $novo_nome_arquivo . "_" . $nome_anexo;
            move_uploaded_file($caminho_temp_anexo, $caminho_salva_anexo);

        }
        
        $result = $this->model_functions->insereDadosMapSistemas($dados_map_sistemas, $nome_anexo);
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