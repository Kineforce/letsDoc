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

        $top = $qtd_resultados != "all" ? "LIMIT " . $qtd_resultados : "";

        $data_array['dados'] = $this->model_functions->retornaInfoMapSistemasFiltro($palavraBuscada, $top);
        $data_array['count'] = $this->model_functions->retornaTotalMapSistemas();

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


        $this->model_functions->updateMapSistemas($dados_map_sistemas_update, $nome_anexo_updated);
        echo json_encode(array("data" => $nome_anexo_updated));

    }

    function retornaExcelMapSistemas(){
        $data_servidores_web = $this->model_functions->retornaExcelMapSistemas();

        $nome_do_arquivo = "map_sistemas_" . date("Y_m_d_H_i_s") . ".xls";

        $conteudo_excel = " <table>
                                <thead>
                                    <tr>
                                        <td>NOME</td>
                                        <td>DESCRICAO</td>
                                        <td>ANEXO</td>
                                        <td>DATABASE</td>
                                        <td>SERVIDOR</td>
                                        <td>SETOR</td>
                                        <td>OCORRENCIA</td>
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
                $conteudo_excel .= "<td>" . utf8_decode($linha['ANEXO']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['DATABASE']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['SERVIDOR']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['SETOR']) . "</td>";
                $conteudo_excel .= "<td>" . utf8_decode($linha['OCORRENCIA']) . "</td>";
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