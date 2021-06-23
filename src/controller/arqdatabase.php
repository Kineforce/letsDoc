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

        $top = $qtd_resultados != "all" ? "TOP " . $qtd_resultados : "";

        $data_array['dados'] = $this->model_functions->retornaInfoDatabaseFiltro($palavraBuscada, $top);
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

    function retornaExcelDatabase(){
        $data_servidores_web = $this->model_functions->retornaExcelDatabase();

        $nome_do_arquivo = "servidores_database_" . date("Y_m_d_H_i_s") . ".xls";

        $conteudo_excel = " <table>
                                <thead>
                                    <tr>
                                        <td>NOME</td>
                                        <td>DESCRICAO</td>
                                        <td>AMBIENTE</td>
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
                $conteudo_excel .= "<td>" . utf8_decode($linha['AMBIENTE']) . "</td>";
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