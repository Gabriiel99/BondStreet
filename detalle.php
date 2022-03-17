<?php 

  require './config/config.php';
  require './config/conexion.php';
 $db= new Conexion();
 $con = $db->conectar();


 $idproducto = isset($_GET['id_producto']) ? $_GET['id_producto'] : '';//traemos el producto obtenemos su id
 $token = isset( $_GET['token']) ? $_GET['token'] : '';//traemos el token



if ($idproducto == '' || $token == '') {
  echo 'Error al procesar la peticion';
  exit;
}
else{
//desencripta el token y el producto 
$token_tmp=hash_hmac('sha1', $idproducto, KEY_TOKEN);
if ($token == $token_tmp) {

$sql=$con->prepare("SELECT count(id_producto) FROM productos WHERE id_producto=? AND activo=1");

$sql->execute([$idproducto]);
if ($sql->fetchColumn() > 0) {
  
  $sql=$con->prepare("SELECT nombre_producto ,detalle_producto , precio, imagen FROM productos WHERE id_producto=? AND activo=1 LIMIT 1");
  $sql->execute([$idproducto]);
  $row= $sql->fetch(PDO::FETCH_ASSOC);

  $nombreproducto = $row['nombre_producto'];
  $detalleproducto = $row['detalle_producto'] ;
  $precio = $row['precio'];
  $imagen = $row['imagen'];
}
}}
  
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@700&display=swap" rel="stylesheet"> 
	
	<!--Link Font-Awesome - Icon-->

	<script src="https://use.fontawesome.com/11ba0951b6.js"></script>
	<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <title>BondStreet - Tienda de indumentaria Online</title>
</head>
  <body>
  	<!--MENU -->
    <div class="container-fluid">
        <header><!-- Header -->
            <div id="top-header"><!-- Header Top-->
				<div class="container d-flex justify-content-between">
					<ul class="header-links">
						<li><a href="#"><img src="./img/phono.png" height="20px">+54 9 381 654-6278</a></li>
						<li><a href="#"><img src="./img/email.png" height="20px">bondStreet@gmail.com</a></li>
						<li><a href="https://www.google.com.ar/maps/place/Buenos+Aires+121,+T4000+San+Miguel+de+Tucum%C3%A1n,+Tucum%C3%A1n/@-26.8322236,-65.2090798,17z/data=!3m1!4b1!4m5!3m4!1s0x94225c11c2e3c8ef:0xccc317eaa5764464!8m2!3d-26.8322284!4d-65.2068911?hl=es" target="_blank"><img src="./img/location.png" height="20px">Buenos Aires 185</a></li>
					</ul>
					<div class="dropdown account clear-fix">
						<?php if(empty($_SESSION)): ?>			
						<img src="./img/user.png" class="dropdown-toggle" type="button" id="dropaccount" data-bs-toggle="dropdown" aria-expanded="false">

						<ul class="dropdown-menu dropdown-menu-dark text-center text-uppercase" aria-labelledby="dropaccount">
					
							<li data-bs-toggle="modal" data-bs-target="#signUp"><a class="dropdown-item" href="#">Registrarse</a></li>
							<li data-bs-toggle="modal" data-bs-target="#login"><a class="dropdown-item" href="#">Iniciar Sesion</a></li>

						</ul>	
						<?php else:
							include './config/session.php';?>
						<?php endif ?>
						</div>
				</div>	
			</div><!-- Fin Header Top-->
			<div id="header"><!-- Header Menu-->
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-sm-12"><!--Logo -->
							<div class="header-logo">

							<a href="index.php">

BondStreet

	</a>
							</div>
						</div><!-- Logo -->
						<div class="col-md-6 col-sm-12">
							<div class="header-search"><!-- Menu Buscar-->
								
							</div>
						</div><!-- Menu Buscar -->
						<div class="col-md-3 d-flex justify-content-center align-items-center">
							<div>
							<a href="./paypal/checkout.php" class="btn btn-warning">Mi Carrito
      <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
							</div>	
					</div>
				</div><!-- Fin Header Menu -->
			</div>
        </header><!-- Fin Header -->
<!-- FIN MENU --><br><br><br><br>

<main>
	<div class="container">
    <div class="row">
      <div class="col-md-6 order-md-1">

<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
	<img src="./img/<?php echo $imagen;?> " alt="" class="img-fluid"></a>

    </div>
   
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>



      </div>
      <div class="col-md-6 order-md-2">
        <h2 ><?php echo $nombreproducto; ?></h2>
        <h2> <?php echo MONEDA . number_format($precio,2,',','.'); ?></h2>
        <p class="lead">
          <?php echo $detalleproducto;  ?>
        </p>
        <div class="d-grid gap-3 col-10 mx-auto">
          <button class="btn btn-primary" type="button" onclick="addProducto(<?php echo $idproducto; ?>, '<?php echo $token_tmp; ?>')">Agregar al Carrito</button>
        </div>
       
      </div>
    </div>	      
</div>
</main>
<footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Sobre Nosotros</h3>
							<p>BondStreet es un local comercial de ventas de indumentaria en general para todo publico, situado en la ciudad de San Miguel de Tucumán.</p>
						</div>
					</div>

					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Contacto</h3>
							<ul class="footer-links">
								<li><a href="#"><i class="fa fa-map-marker"></i>Buenos Aires 185</a></li>
								<li><a href="#"><i class="fa fa-phone"></i>+54 9 381 654-6278</a></li>
								<li><a href="#"><i class="fa fa-envelope-o"></i>bondStreet@gmail.com</a></li>
							</ul>
						</div>
					</div>

					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Información</h3>
							<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptates, mollitia omnis, velit dolor molestias in dignissimos culpa numquam delectus obcaecati aut natus quidem eveniet nobis provident sed dolorum nesciunt quaerat.</p>
						</div>
					</div>

					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Servicios</h3>
							<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi atque asperiores distinctio error, ab odit officiis sequi itaque adipisci blanditiis suscipit nam perferendis optio corrupti aut repellendus recusandae possimus ducimus?</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-center">
						<ul class="footer-payments">
							<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
							<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
						</ul>
					</div>
				</div>
			</div>

			<div id="bottom-footer">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<span class="copyright">
								<p>&copy;<script>document.write(new Date().getFullYear()); </script> Todos los derechos reservados | EnzoProgramers.</p>
							</span>
						</div>
					</div>
				</div>
			</div>
		</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


<!-- Peticion AJAX-->
  <script>
    function addProducto(idproducto, token){
let url= 'clases/carrito.php'
let formData= new FormData()
formData.append('id_producto', idproducto)
formData.append('token', token)

fetch(url, {
  method: 'POST',
  body: formData,
  mode:'cors'
}).then(response => response.json())
  .then(data =>{
    if(data.ok){
      let elemento = document.getElementById("num_cart")
      elemento.innerHTML = data.numero
      }
      })
    }
    
    
  </script>

  
  </body>
</html>