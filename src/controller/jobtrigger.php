<?php

require_once ('../helper/general_helpers.php');

class JobTrigger_controller extends Helpers{

    function __construct(){
        require('../model/jobtrigger_model.php');

        $this->model_functions = new JobTrigger_model();
    }

    function retornaDataFiltradaJobTrigger(){

        $palavraBuscada = htmlspecialchars((isset($_GET['retornaDataFiltradaJobTrigger'])) ? $_GET['retornaDataFiltradaJobTrigger'] : '');

        $data_array['dados'] = $this->model_functions->retornaInfoJobTriggerFiltro($palavraBuscada);
    
        echo json_encode($data_array);

    }

    function retornaDadosJobTrigger(){
        
        $result['dados'] = $this->model_functions->buscaDadosJobTrigger();
        echo json_encode($result);

    }

    function cadastraDadosJobTrigger(){

        $dados_job_trigger = $_POST['cadastraDadosJobTrigger'];

        $result = $this->model_functions->insereDadosJobTrigger($dados_job_trigger);
        echo json_encode($result);  

    }

    function deletaRegistroJobTrigger(){

        $id_job_trigger = $_POST['deletaIdJobTrigger'];

        $result = $this->model_functions->deletaDadosJobTrigger($id_job_trigger);
        echo json_encode($result);

    }

    function updateJobTrigger(){

        $dados_job_trigger = $_POST['updateIdJobTrigger'];

        $result = $this->model_functions->updateJobTrigger($dados_job_trigger);
        echo json_encode($result);

    }

}


?>