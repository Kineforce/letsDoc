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



}