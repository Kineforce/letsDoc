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

    function retornaExcelJobTrigger(){
        $data_servidores_web = $this->model_functions->retornaExcelJobTrigger();

        $nome_do_arquivo = "jobs_triggers_" . date("Y_m_d_H_i_s") . ".xls";

        $conteudo_excel = " <table>
                                <thead>
                                    <tr>
                                        <td>NOME</td>
                                        <td>DESCRICAO</td>
                                        <td>TABELA</td>
                                        <td>DATABASE</td>
                                        <td>ATIVO</td>
                                        <td>DATA_INSERT</td>
                                    </tr>
                                </thead>
                            ";

        $conteudo_excel .= " <tbody>";
        
        foreach($data_servidores_web as $linha){
            $conteudo_excel .= "<tr>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['NOME']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['DESCRICAO']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['TABELA']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['DATABASE']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['ATIVO']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['DATA_INSERT']) . "</td>";
            $conteudo_excel .= "</tr>";
        }

        $conteudo_excel .= " </tbody>";
        $conteudo_excel .= " </table>";
        
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$nome_do_arquivo);

        echo $conteudo_excel;

    }
}


?>