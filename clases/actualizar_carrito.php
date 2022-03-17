<?php

require '../config/config.php';
require '../config/conexion.php';

if(isset($_POST['action'])){

    $action = $_POST['action'];
    $idproducto = isset($_POST['id_producto']) ? $_POST['id_producto'] :0;

    if($action == 'agregar'){
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] :0;
       $respuesta= agregar($idproducto, $cantidad);
       if($respuesta > 0){
           $datos['ok']=true;
       }else{
        $datos['ok']=false;
       }
       $datos['sub'] =  MONEDA . number_format($respuesta,2,',','.');

    }elseif($action == 'eliminar'){
        $datos['ok']=eliminar($idproducto);

    }
    else{
        $datos['ok']=false;
    }
}else{
    $datos['ok']=false;

}
echo json_encode($datos);

function agregar($idproducto, $cantidad){
    $res = 0;
    if($idproducto > 0 && $cantidad > 0 && is_numeric(($cantidad))){
        if(isset($_SESSION['carrito']['productos'][$idproducto])){
            $_SESSION['carrito']['productos'][$idproducto] = $cantidad;

            $db= new Conexion();
            $con = $db->conectar();

            $sql=$con->prepare("SELECT  precio FROM productos WHERE id_producto=? AND activo=1 LIMIT 1");
            $sql->execute([$idproducto]);
            $row= $sql->fetch(PDO::FETCH_ASSOC);         
            $precio = $row['precio'];
            $res= $cantidad * $precio;
          return $res;


        }
    }else{
        return $res;
    }

}
function eliminar($idproducto){
    if($idproducto > 0){
        if(isset($_SESSION['carrito']['productos'][$idproducto]))
        {
            unset($_SESSION['carrito']['productos'][$idproducto]);
            return true;
        }

    }else{
        return false;
    }
}