<?php

require_once ('../helper/general_helpers.php');

class MapSistemas_controller extends Helpers{

    function __construct(){
        require('../model/mapsistemas_model.php');

        $this->model_functions = new MapSistemas_model();
    }

    function retornaDadosMapSistemas(){

        $dados_map_sistemas = $_GET['retornaDadosMapSistemas'];

        $palavraBuscada = htmlspecialchars((isset($dados_map_sistemas['palavraBuscada'])) ? $dados_map_sistemas['palavraBuscada'] : '');

        $qtd_resultados = htmlspecialchars((isset($dados_map_sistemas['qtd'])) ? $dados_map_sistemas['qtd'] : '');

        $limit = $qtd_resultados != "all" ? "LIMIT " . $qtd_resultados : "";

        $data_array['dados'] = $this->model_functions->retornaInfoMapSistemasFiltro($palavraBuscada, $limit);
    
        echo json_encode($data_array);

    }

    function cadastraDadosMapSistemas(){

        $nome_anexo = "";
        $dados_map_sistemas = $_POST;
        $novo_nome_arquivo = '';

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
            unlink($anexo_diretorio);
        } 

        $result = $this->model_functions->deletaDadosMapSistemas($dados_map_sistemas);
        echo json_encode($result);

    }

    function updateMapSistemas(){

        $nome_anexo_updated = "";
        $dados_map_sistemas_update = $_POST;

        // Caso exista algum anexo enviado no post
        if (!empty($_FILES)){

            // Verifica se já não existe um arquivo para o registro 
            $id_linha_atual = $_POST['id_map_sistemas'];
            $result_anexo = $this->model_functions->buscaAnexoAtualMapSistemas($id_linha_atual);

            // Caso exista, deletar o arquivo antigo
            if ($result_anexo){
 
                $dir = "../uploads_anexos/";
                $anexo_diretorio = $dir . $result_anexo['ANEXO'];

                unlink($anexo_diretorio);

            }

            // Move o arquivo para a pasta
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