<?php
include_once './connection.php';

class Productos extends Connection{

    public $sql;
    public $statement;
    public $res;

    public function dataProducts(){

        $this->sql = 'SELECT * FROM productos';
        $this->statement = $this->conn->prepare($this->sql);
        $this->statement->execute();

        return $this->statement->fetchAll();

    }  

  
}

