<?php

class Connection{

    public $conn;

    public function __construct(){

        try{
            $this->conn = new PDO('mysql:host=localhost;dbname=bondStreet', 'root', '');
            //echo 'Connection Success';
        
        } catch (PDOException $e){
        
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

//$conn = new Connection();
