<?php

$url = 'mysql:host=localhost;dbname=bondStreet';
$user = 'root';
$pass = '';

try{
    $conn = new PDO($url, $user, $pass);
    //echo 'Connection Success';

} catch (PDOException $e){

    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>