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
            $novo_nome_arquivo = $momento_atual . "_" . $nome_anexo;
            $caminho_temp_anexo = $_FILES['anexo']['tmp_name'];
            $caminho_salva_anexo = "../uploads_anexos/" . $novo_nome_arquivo;
            move_uploaded_file($caminho_temp_anexo, $caminho_salva_anexo);

            $nome_anexo = $novo_nome_arquivo;
        }
        
        $result = $this->model_functions->insereDadosMapSistemas($dados_map_sistemas, $novo_nome_arquivo);
        echo json_encode($result);  

    }

    function deletaRegistroMapSistemas(){

        $dados_map_sistemas = $_POST['deletaMapSistemas'];
        $possivel_anexo_post = $dados_map_sistemas['anexo'];
        $dir = "../uploads_anexos/";
        $anexo_diretorio = $dir . $possivel_anexo_post;

        // Verifica se o arquivo que veio no post existe, caso sim, deleta o mesmo
        if (file_exists($anexo_diretorio)){
            echo json_encode("Arquivo existe!");
            unlink($anexo_diretorio);
        } 

        $result = $this->model_functions->deletaDadosMapSistemas($dados_map_sistemas);
        echo json_encode($result);

    }

    function updateMapSistemas(){

        $nome_anexo_updated = "";
        $dados_map_sistemas_update = $_POST;

        if (!empty($_FILES)){
            $nome_anexo = $_FILES['anexo']['name'];
            $momento_atual = date("Y_m_d_H_i_s");
            $novo_nome_arquivo = $momento_atual . "_" . $nome_anexo;
            $caminho_temp_anexo = $_FILES['anexo']['tmp_name'];
            $caminho_salva_anexo = "../uploads_anexos/" . $novo_nome_arquivo;
            move_uploaded_file($caminho_temp_anexo, $caminho_salva_anexo);

            $nome_anexo_updated = $novo_nome_arquivo;
        }


        $result = $this->model_functions->updateMapSistemas($dados_map_sistemas_update, $nome_anexo_updated);
        echo json_encode($result);

    }

}


?>