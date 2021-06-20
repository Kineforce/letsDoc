<?php

require_once ('../helper/general_helpers.php');

class ArqDatabase_controller extends Helpers {

    public $model_functions;

    function __construct(){
        require('../model/arqdatabase_model.php');

        $this->model_functions = new ArqDatabase_model();

    }

    function retornaInfoDatabase(){


        $dados_database = $_GET['retornaInfoDatabase'];

        $palavraBuscada = htmlspecialchars((isset($dados_database['palavraBuscada'])) ? $dados_database['palavraBuscada'] : '');

        $qtd_resultados = htmlspecialchars((isset($dados_database['qtd'])) ? $dados_database['qtd'] : '');

        $limit = $qtd_resultados != "all" ? "LIMIT " . $qtd_resultados : "";

        $data_array['dados'] = $this->model_functions->retornaInfoDatabaseFiltro($palavraBuscada, $limit);
        $data_array['count'] = $this->model_functions->retornaTotalDatabase();

        echo json_encode($data_array);

    }

    function cadastraInfoDatabase(){

        $dadosDatabase = $_POST['cadastraDadosDatabase'];

        $insert = $this->model_functions->insereInfoDatabase($dadosDatabase);
        
        echo json_encode($insert);
    }

    function deletaIdDatabase(){

        $dadosDatabase = $_POST['deletaIdDatabase'];

        $delete = $this->model_functions->deletaInfoDatabase($dadosDatabase);

        echo json_encode($delete);
    }

    function updateInfoDatabase(){

        $dadosServidor = $_POST['updateIdDatabase'];

        $update = $this->model_functions->updateInfoDatabase($dadosServidor);
    
        echo json_encode($update);
    }

    function buscaSubItemsDatabase(){
        $dadosServidor = $_GET['buscaSubItemsDatabase'];

        $data_array['dados'] = $this->model_functions->retornaSubItemsDatabase($dadosServidor);

        echo json_encode($data_array);

    }

    function cadastraItemDatabase(){

        $dadosDatabase = $_POST['cadastraDadosItemDatabase'];

        $insert = $this->model_functions->insereInfoItemDatabase($dadosDatabase);
        
        echo json_encode($insert);

    }

    function deletaSubItemDatabase(){

        $dadosDatabase = $_POST['deletaInfoItemDatabase'];

        $delete = $this->model_functions->deletaInfoItemDatabase($dadosDatabase);

        echo json_encode($delete);

    }

    function updateDatabaseSubitem(){

        $dadosServidor = $_POST['updateIdDatabaseSubItem'];

        $update = $this->model_functions->updateDatabaseItem($dadosServidor);
            
        echo json_encode($update);


    }



}