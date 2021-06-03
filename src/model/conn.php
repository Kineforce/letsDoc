
<?php

class SQliteConnection {

    private $pdo;

    public function connect() {
        if ($this->pdo == null){
            $this->pdo = new \PDO("sqlite:../model/database.db");
        }
        return $this->pdo;
    }

}


?>
