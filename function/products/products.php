<?php

include_once '../connection/connection.php';



$sql = 'SELECT * FROM productos';
$sent = $conn->prepare($sql);
$sent->execute();

$res = $sent->fetchAll();