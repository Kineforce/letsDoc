<?php


class Helpers {

    /**
     * Retorna a data formatada para retornar ao front-end pelo json_encode
     */
    function fetchDataToJsonEncode($dados){
        $data = [];

        while ($row = $dados->fetch(\PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

}
