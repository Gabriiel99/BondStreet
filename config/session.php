<?php
    //session_start();

    if(isset($_SESSION['user'])){
        echo 'BIENVENIDO: ';
        echo $_SESSION['nom'];
        echo '<a href="./config/exit.php" class="btn btn-danger">Salir</a>';
    }
?>