<?php 
 require 'config/config.php';
 require 'config/conexion.php';

 $db= new Conexion();
 $con = $db->conectar();

 $sql=$con->prepare("SELECT id_producto, nombre_producto , precio FROM productos WHERE activo=1");
 $sql->execute();
 $res= $sql->fetchAll(PDO::FETCH_ASSOC);

 //session_destroy();//para eliminar todo de mi carrito

?>
<!DOCTYPE html>
<html lang="es">
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
	
    <div class="container-fluid">
        <header><!-- Header -->
            <div id="top-header"><!-- Header Top-->
				<div class="container d-flex justify-content-between">
					<ul class="header-links">
						<li><a href="#"><img src="./img/phono.png" height="20px">+54 9 381 654-6278</a></li>
						<li><a href="#"><img src="./img/email.png" height="20px">bondStreet@gmail.com</a></li>
						<li><a href="https://www.google.com.ar/maps/place/Buenos+Aires+121,+T4000+San+Miguel+de+Tucum%C3%A1n,+Tucum%C3%A1n/@-26.8322236,-65.2090798,17z/data=!3m1!4b1!4m5!3m4!1s0x94225c11c2e3c8ef:0xccc317eaa5764464!8m2!3d-26.8322284!4d-65.2068911?hl=es" target="_blank"><img src="./img/location.png" height="20px">Buenos Aires 185</a></li>
					</ul>
					<!--Div Cuenta-->
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
						
								<!-- Sign Up Correspondiente al li>a Registrarse-->
								<div class="modal fade" id="signUp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h2 class="modal-title align-center" id="exampleModalLabel">Resgistrate</h2>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<form action="./user/register.php" method="POST">
												<?php 
													include './user/formRegister.php';
												?>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!--Login-->
							<div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h2 class="modal-title" id="exampleModalLabel">Iniciar sesión</h2>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<form action="validar.php" method="POST">
												<div class="mb-2">

													<label for="email" class="col-form-label">E-Mail:</label>
													<input type="text" class="form-control" name="email" id="user" placeholder="E-Mail">

													<label for="pass" class="col-form-label">Contraseña:</label>
													<input type="password" class="form-control" name="pass" id="pass">
													
												</div>

												<button type="button" class="btn btn-blue" data-bs-dismiss="modal">Cancelar</button>
												<input type="submit" class="btn btn-red" value="Acceder">

											</form>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					
					<!--Div Cuenta Final-->
				</div>
			</div><!-- Fin Header Top-->
			<div id="header"><!-- Header Menu-->
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-sm-12"><!--Logo -->
							<div class="header-logo">

								<a href="index.php">
									BONDSTREET
								</a>
							</div>
						</div><!-- Logo -->
						<div class="col-md-6 col-sm-12">
							<div class="header-search"><!-- Menu Buscar-->
								<form>
									<select class="input-select">
										<option value="1">Categorías</option>
										<option value="2">Hombres</option>
										<option value="3">Damas</option>
										<option value="4">Niños</option>
									</select>
									<input class="input" placeholder="Buscar Aquí">
									<button>Buscar</button>
								</form>
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

		<div class="container-fluid"><!-- Navegacion -->
			<div class="row">
				<div class="col-md-12">
					<nav class="nav">
						<a class="nav-link"href="#">Hombres</a>
						<a class="nav-link" href="#">Damas</a>
						<a class="nav-link" href="#">Niños</a>
						<a class="nav-link" href="#">Deportes</a>
						<a class="nav-link" href="#">Accesorios</a>
						<a class="nav-link" href="#">Ofertas</a>
					</nav>
				</div>
			</div>
		</div><!-- Fin Navegacion -->
		<section class="container d-flex mt-5"><!-- Seccion Cards -->


			<div class="row mx-auto">

				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
					
					<?php 
					require_once('./products/products.php');
					
					$res = (new Productos)->dataProducts();

					?>
					<?php foreach($res as $dato): ?>

						<div class="card-box text-center shadow-sm ms-5" style="width: 18rem;">
							<img src="./img/<?php echo $dato['imagen'];?> " alt="<?php echo $dato['nombre_producto'];?> " class="img-fluid"></a>
							<div class="card-body" id="card-body">
								<h3 class="card-title"><?php echo $dato['nombre_producto'] ?></h3>
								
								<p class="card-text"><strong><?php echo $dato['detalle_producto'] ?></strong></p>
								<p class="precio"><span>$<?php echo $dato['precio'] ?></span></p>
								<a href="detalle.php?id_producto=<?php echo $dato['id_producto'];?>&token=<?php echo hash_hmac('sha1', $dato['id_producto'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
								<button class="btn btn-outline-success" type="button" onclick="addProducto(
          <?php echo $dato['id_producto']; ?>, '<?php echo hash_hmac('sha1', $dato['id_producto'], KEY_TOKEN);  ?>')">Agregar al Carrito</button>
							</div>
						</div>

					<?php endforeach ?>
				</div>
			</div>

		</section><!-- Fin Seccion Cards -->

		<div id="newsletter" class="section"><!-- Boletin Novedades -->
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="newsletter">
							<p>Suscríbete para más Novedades!</p>
							<form>
								<input class="input" type="email" placeholder="Ingresa tu E-Mail">
								<button class="newsletter-btn"><i class="fa fa-envelope"></i> Suscríbete</button>
							</form>
							<ul class="newsletter-follow">
								<li>
									<a href="http://facebook.com.ar" target="_blank"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-instagram"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-pinterest"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!-- Fin Boletin Novedades -->

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


		<!--SCRIPT-->

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

	<script src="./js/app.js"></script>

	<!--Peticion AJAX para agregar al carrito-->
    <script>
      function addProducto(idproducto, token){

        let url= 'clases/carrito.php'
        let formData= new FormData()
        formData.append('id_producto', idproducto)
        formData.append('token', token)

        fetch(url, {
          method: 'POST',
          body: formData,
          mode: 'cors'

        }).then(response => response.json())
        .then(data =>{
          if(data.ok){
            let elemento = document.getElementById('num_cart')
            elemento.innerHTML = data.numero
          }
        })
      }
    </script>

    
</body>
</html>
