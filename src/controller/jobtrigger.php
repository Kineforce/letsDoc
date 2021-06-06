<?php

require_once ('../helper/general_helpers.php');

class JobTrigger_controller extends Helpers{

    function __construct(){
        require('../model/jobtrigger_model.php');

        $this->model_functions = new JobTrigger_model();
    }


    

}


?>