<?php

require_once ('../helper/general_helpers.php');

class ArqServers_controller extends Helpers{

    public $model_functions;

    function __construct(){
        require('../model/arqservers_model.php');

        $this->model_functions = new ArqServers_Model();

    }

    function retornaInfoServidores(){

        $dados_servidor = $_GET['retornaInfoServidores'];

        $palavraBuscada = htmlspecialchars((isset($dados_servidor['palavraBuscada'])) ? $dados_servidor['palavraBuscada'] : '');

        $qtd_resultados = htmlspecialchars((isset($dados_servidor['qtd'])) ? $dados_servidor['qtd'] : '');

        $limit = $qtd_resultados != "all" ? "LIMIT " . $qtd_resultados : "";

        $data_array['dados'] = $this->model_functions->retornaInfoArqServerFiltro($palavraBuscada, $limit);
        $data_array['count'] = $this->model_functions->retornaTotalArqServer();

        echo json_encode($data_array);
    }

    function cadastraDadosServidor(){

        $dadosServidor = $_POST['cadastraDadosServidor'];

        $insert = $this->model_functions->insereInfoArqServer($dadosServidor);
        
        echo json_encode($insert);
    }

    function cadastraDadosItemServidor(){
        $dadosServidor = $_POST['cadastraDadosItemServidor'];

        $insert = $this->model_functions->insereInfoItemArqServer($dadosServidor);
    
        echo json_encode($insert);
    }

    function deletaIdServidor(){

        $dadosServidor = $_POST['deletaIdServidor'];

        $delete = $this->model_functions->deletaInfoArqServer($dadosServidor);
        
        echo json_encode($delete);

    }

    function deletaInfoItemArqServer(){
        $dadosServidor = $_POST['deletaInfoItemArqServer'];

        $delete_item = $this->model_functions->deletaInfoItemArqServer($dadosServidor);

        echo json_encode($delete_item);
    }

    function updateIdServidor(){

        $dadosServidor = $_POST['updateIdServidor'];

        $update = $this->model_functions->updateInfoArqServer($dadosServidor);
    
        echo json_encode($update);
    }

    function updateIdServidorSubItem(){
        $dadosServidor = $_POST['updateIdServidorSubItem'];

        $update = $this->model_functions->updateItemInfoArqServer($dadosServidor);
    
        echo json_encode($update);
    }

    function buscaSubItemsServidor(){
        $dadosServidor = $_GET['buscaSubItemsServer'];

        $data_array['dados']= $this->model_functions->retornaSubItemsServer($dadosServidor);

        echo json_encode($data_array);

    }

    function retornaExcelServidor(){
        $data_servidores_web = $this->model_functions->retornaServerExcel();

        $nome_do_arquivo = "servidores_web_" . date("Y_m_d_H_i_s") . ".xls";
        $conteudo_excel = " <table>
                                <thead>
                                    <tr>
                                        <td>NOME</td>
                                        <td>OBJETIVO</td>
                                        <td>LINGUAGEM</td>
                                        <td>ATIVO</td>
                                        <td>DATA_INSERT</td>
                                    </tr>
                                </thead>
                            ";

        $conteudo_excel .= " <tbody>";
        
        foreach($data_servidores_web as $linha){
            $conteudo_excel .= "<tr>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['NOME']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['OBJETIVO']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['LINGUAGEM']) . "</td>";
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