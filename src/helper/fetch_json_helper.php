<?php


class Helpers {

    /**
     * Retorna a data formatada para retornar ao front-end pelo json_encode
     */
    function fetchDataToJsonEncode($dados){
        $data = array();

        while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
           array_push($data, $row);
        }

        return $data;
    }

}
