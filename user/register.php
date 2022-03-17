<?php

include '../connection.php';
include './formRegister.php';

class RegisterUser extends Connection{

    public $name;
    public $lastName;
    public $address;
    public $rolUser;
    public $phone;
    public $email;
    public $user;
    public $pass;
    public $idUser;

    public $sql;
    public $statement;
    public $exist;

    public function register($name, $lastName, $address, $rolUser, $phone, $email, $user, $pass){

        $this->name = $name;
        $this->lastName = $lastName;
        $this->address = $address; 
        $this->rolUser = $rolUser;
        $this->phone = $phone;
        $this->email = $email;
        $this->user = $user;
        $this->pass = $pass;

        $this->sql = 'INSERT INTO usuarios (nombreUsuario, apellidoUsuario, direccion, rolUsuario, telefono, email, user, pass) VALUES (?,?,?,?,?,?,?,?)';

        $this->statement = $this->conn->prepare($this->sql);

        $this->statement->execute(array($name, $lastName, $address, $rolUser, $phone, $email, $user, $pass)); 
              
    }

    public function checkUser($user, $email){

        $this->user;
        $this->email;

        $this->sql = 'SELECT * FROM usuarios WHERE user = ? AND email = ?';
        $this->statement = $this->conn->prepare($this->sql);
        $this->statement->execute(array($user,$email));

        return $this->statement->fetchColumn();
    }

}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $num_row = (new RegisterUser)->checkUser($_REQUEST['user'], $_REQUEST['email']);
    if($num_row >= 1){

        echo "<script>alert('El usuario ya existe!');window.location.href='../index.php';</script>";

    } else {

            try{
                (new RegisterUser)->register(
                    $_REQUEST['name'], $_REQUEST['lastName'], $_REQUEST['address'], $_REQUEST['rolUser'],$_REQUEST['phone'], $_REQUEST['email'], $_REQUEST['user'], password_hash($_REQUEST['pass'], PASSWORD_DEFAULT)
                );
        
                echo "<script>alert('Usuario Registrado Satisfactoriamente!');window.location.href='../index.php';</script>";
        
            } catch (\Throwable $th){
                echo "¡Error!: {$th->getMessage()}";
            }
        }
    }
    


													
