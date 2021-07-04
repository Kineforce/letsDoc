<?php
require_once('../session_auth/session.php');

class Helpers
{

    /**
     * Método que cria um excel pronto para exportação
     * 
     * @param string $tabela_nome_arq Nome do arquivo a ser gerado em .xls
     * @param string $caption Titulo da table que irá ser gerada no .xls
     * @param array $array_td_header Array contendo os TD's respectivos a serem gerados nas TR do THEADER
     * @param array $array_td_body Array contendo os TD's respectivos a serem gerados nas TR do TBODY 
     * @author Lucas Souza Martins <lucas.martins@iesb.br>
     * 
     * @return string
     */
    function retornaExcelExportacaoGeral($tabela_nome_arq, $caption, $array_td_header, $array_td_body)
    {

        if ($tabela_nome_arq == "as") {
            $tabela_nome_arq = "servidores_web_";
        }

        if ($tabela_nome_arq == "db") {
            $tabela_nome_arq = "servidores_database_";
        }

        if ($tabela_nome_arq == "mt") {
            $tabela_nome_arq = "mapeamento_trig_job_";
        }

        if ($tabela_nome_arq == "ms") {
            $tabela_nome_arq = "mapeamento_sistemas_";
        }

        $nome_do_arquivo = $tabela_nome_arq . date("Y_m_d_H_i_s") . ".xls";

        $caption_excel = utf8_decode($caption);

        $style_excel = "<style>
                            table, th, td {
                                border: 1px solid black;
                            }
                        </style>";

        $header_excel = "<tr>";

        foreach ($array_td_header as $td_value) {
            $header_excel .= "<td>$td_value</td>";
        }

        $header_excel .= "</tr>";

        $conteudo_excel  = " 
                                $style_excel
                                <table>
                                    <caption>$caption_excel</caption>
                                    <thead>
                                        $header_excel
                                </thead>
                            ";

        $conteudo_excel .= " <tbody>";

        $counter_colorir_linha = 0;

        foreach ($array_td_body as $linha => $valor) {
            $colorir_tr = ($counter_colorir_linha % 2 == 0) ? "bgcolor='#808080'" : "bgcolor='##5a5a5a'";
            $conteudo_excel .= "<tr $colorir_tr>";

            foreach (array_keys($valor) as $td) {
                if ($td != "ID") {
                    $conteudo_excel .= "<td>" . utf8_decode($valor[$td]) . "</td>";
                }
            }

            $conteudo_excel .= "</tr>";
            $counter_colorir_linha = $counter_colorir_linha + 1;
        }

        $conteudo_excel .= " </tbody>";
        $conteudo_excel .= " </table>";

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $nome_do_arquivo);

        return $conteudo_excel;
    }

    /**
     * Converte um array retornado pelo PDO em UTF-8
     */
    function outputFormatado($dados_array){

        $array_utf8 = array();
        $array_aux = array();

        foreach ($dados_array as $arr_row){
            foreach($arr_row as $key => $value){                
                $array_aux[$key] = utf8_encode(htmlspecialchars($value));
            }
            array_push($array_utf8, $array_aux);
        }

        return $array_utf8;

    }
}
