<?php
    session_start();
    include './connection.php';
    
    class Validar extends Connection{

        public $email;
        public $pass;
        public $sql;
        public $statement;
        public $datos;
        
        public function signIn($email, $pass) {
            $this->pass = $pass;
            $this->email = $email;

            $this->sql = 'SELECT * FROM usuarios WHERE email = ? LIMIT 1';
            $this->statement = $this->conn->prepare($this->sql);
            $this->statement->execute(array($email));

            $data = $this->statement->fetch();
                    
            if(password_verify($this->pass, $data['pass'])){
                $_SESSION['idusu'] = $data['idUsuario'];
                $_SESSION['user'] = $data['user'];
                $_SESSION['nom'] = $data['nombreUsuario'].", ".$data['apellidoUsuario'];
                header("location: index.php");


            } 
            else {
                echo "<script>alert('Usuario o Password Incorrectos');</script>";
            }
        }
    }
    

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        try {

            $signIn = new Validar();
            $signIn->signIn($_REQUEST['email'], $_REQUEST['pass']);

            echo "<script>alert('Bienvenido');window.location.href='index.php';</script>";
        } catch (Error $e){
            echo 'Error!'.$e->getMessage();
        }

    }
    