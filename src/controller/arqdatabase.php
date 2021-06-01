<?php

require_once ('../helper/fetch_json_helper.php');

class ArqDatabase_controller extends Helpers {

    public $model_functions;

    function __construct(){
        require('../model/arqdatabase_model.php');

        $this->model_functions = new ArqDatabase_model();

    }


    function retornaInfoDatabase(){

        $dados = $this->model_functions->retornaInfoDatabase();
        $data_array['dados'] = $this->fetchDataToJsonEncode($dados);
    
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


}