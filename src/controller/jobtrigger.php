<?php

require_once ('../helper/general_helpers.php');

class JobTrigger_controller extends Helpers{

    function __construct(){
        require('../model/jobtrigger_model.php');

        $this->model_functions = new JobTrigger_model();
    }

    function retornaDadosJobTrigger(){
        
        $dados_job_trigger = $_GET['retornaDadosJobTrigger'];

        $palavraBuscada = htmlspecialchars((isset($dados_job_trigger['palavraBuscada'])) ? $dados_job_trigger['palavraBuscada'] : '');

        $qtd_resultados = htmlspecialchars((isset($dados_job_trigger['qtd'])) ? $dados_job_trigger['qtd'] : '');

        $limit = $qtd_resultados != "all" ? "LIMIT " . $qtd_resultados : "";

        $data_array['dados'] = $this->model_functions->retornaInfoJobTriggerFiltro($palavraBuscada, $limit);
        $data_array['count'] = $this->model_functions->retornaTotalJobTrigger();

        echo json_encode($data_array);

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