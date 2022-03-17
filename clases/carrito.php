<?php 

require '../config/config.php';
//verifica si pasamos el id
if(isset($_POST['id_producto'])){

$idproducto = $_POST['id_producto'];
$token = $_POST['token'];

//traemos nuestro token 
$token_tmp=hash_hmac('sha1', $idproducto, KEY_TOKEN);

if ($token == $token_tmp) {
//guardamos con el session donde si existe que agreguemos el producto contandolos
if(isset($_SESSION['carrito']['productos'][$idproducto])){

$_SESSION['carrito']['productos'][$idproducto] += 1;
	}else {
		$_SESSION['carrito']['productos'][$idproducto] = 1;	
	}

	$datos['numero']= count($_SESSION['carrito']['productos']);//contamos
	$datos['ok']= true; //verifica si llegaron los datos

}else{
	$datos['ok']= false;
}

}else{
	$datos['ok']= false;
}

echo json_encode($datos);//convierte en formato json
 ?>