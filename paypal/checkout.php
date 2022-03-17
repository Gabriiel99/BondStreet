<?php 
 require '../config/config.php';
 require '../config/conexion.php';

 $db= new Conexion();
 $con = $db->conectar();
//verifico si mi variable de session exista, ya que ahi guardamos lo del carrito. y la recibimos
$productos= isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();
//extraer productos de la session

//clave es id de producto y cantidad es la cantidad
if($productos != null){
  foreach($productos as $clave => $cantidad){

//cantidad es un valor para que lo traiga en resultado pero no desde la bd 
    $sql=$con->prepare("SELECT id_producto, nombre_producto , precio , $cantidad AS cantidad FROM productos WHERE id_producto=? AND activo=1");
    $sql->execute([$clave]);
    $lista_carrito[]= $sql->fetch(PDO::FETCH_ASSOC);
  }

}


 $sql=$con->prepare("SELECT id_producto, nombre_producto , precio FROM productos WHERE activo=1");
 $sql->execute();
 $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

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
    <title></title>
  </head>
  <body>
  	<!--MENU -->
    <header><!-- Header -->
            <div id="top-header"><!-- Header Top-->
				<div class="container d-flex justify-content-between">
					<ul class="header-links">
						<li><a href="#"><img src="../img/phono.png" height="20px">+54 9 381 654-6278</a></li>
						<li><a href="#"><img src="../img/email.png" height="20px">bondStreet@gmail.com</a></li>
						<li><a href="https://www.google.com.ar/maps/place/Buenos+Aires+121,+T4000+San+Miguel+de+Tucum%C3%A1n,+Tucum%C3%A1n/@-26.8322236,-65.2090798,17z/data=!3m1!4b1!4m5!3m4!1s0x94225c11c2e3c8ef:0xccc317eaa5764464!8m2!3d-26.8322284!4d-65.2068911?hl=es" target="_blank"><img src="../img/location.png" height="20px">Buenos Aires 185</a></li>
					</ul>
          <div class="dropdown account clear-fix">
						<?php if(empty($_SESSION)): ?>			
						<img src="../img/user.png" class="dropdown-toggle" type="button" id="dropaccount" data-bs-toggle="dropdown" aria-expanded="false">

						<ul class="dropdown-menu dropdown-menu-dark text-center text-uppercase" aria-labelledby="dropaccount">
					
							<li data-bs-toggle="modal" data-bs-target="#signUp"><a class="dropdown-item" href="#">Registrarse</a></li>
							<li data-bs-toggle="modal" data-bs-target="#login"><a class="dropdown-item" href="#">Iniciar Sesion</a></li>

						</ul>	
						<?php else:
							echo 'Bienvenido: ';
              echo $_SESSION['nom'];?>
              <a href="../config/exit.php" class="btn btn-danger">Salir</a>
						<?php endif ?>
						</div>
							
					<!--Div Cuenta Final-->
				</div>
			</div><!-- Fin Header Top-->
			<div id="header"><!-- Header Menu-->
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-sm-12"><!--Logo -->
							<div class="header-logo">

					
								<a href="../index.php">

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
							<a href="checkout.php" class="btn btn-warning">Mi Carrito
      <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
							</div>	
					</div>
				</div><!-- Fin Header Menu -->
			</div>
        </header><!-- Fin Header -->

<!-- FIN MENU --><br>
<main>
	<div class="container">
		<div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>SubTotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php if($lista_carrito == null){
            echo '<tr><td colspan="5" class="text-center"><b>Lista Vacia</b></td></tr>';
          }else{
            $total =0;
            foreach($lista_carrito as $producto){
              $_idproducto= $producto['id_producto'];
              $nombre= $producto['nombre_producto'];
              $precio= $producto['precio'];
              $cantidad = $producto['cantidad'];
              $subtotal= $cantidad * $precio;
              $total+= $subtotal;
            ?>


          
          <tr>
            <td><?php echo $nombre; ?> </td>
            <td><?php echo MONEDA . number_format( $precio,2,',','.');?> </td>
            <td>
              <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad; ?>"
               size="5" id="cantidad_<?php echo $_idproducto; ?>" onchange="actualizaCantidad(this.value, <?php echo $_idproducto;?>)">
            </td>

            <td>
              <div id="subtotal_<?php echo $_idproducto; ?>" name="subtotal[]">
              <?php
              echo MONEDA . number_format( $subtotal,2,',','.');
              ?>

              </div>
            </td> 
            <td>
              
              <a id="eliminar" class="btn btn-warning btn.sm" data-bs-id="<?php echo $_idproducto; ?>"
              data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a>

            </td>
          </tr>
          <?php  } ?>

          <tr>
            <td colspan="3"></td>
            <td colspan="2">
              <p class="h3" id="total"><b>TOTAL:</b>
                <?php echo MONEDA. number_format( $total,2,',','.');?>
              </p>
            </td>
          </tr>
        </tbody>
        <?php } ?>
      </table>
    </div>
<div class="row" >
  <div class="col-md-5 offset-md-7 d-grid gap-2">
  <div id="paypal-payment-button">
</div>
  </div>
</div>
  </div>
</main>

<!-- Modal Para eliminar -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminaModal">Alerta!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Desea eliminar el producto del carrito?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
      </div>
    </div>
  </div>
</div>

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
<!-- SCRIPT PAYPAL COMIENZO -->
<script src="https://www.paypal.com/sdk/js?client-id=AT-4ZX3WPXN4AM1IobF2Lc72W5tWxwKXV2xelgZcpXbDzRKD1sQGhcOw6IZ1a7No6F2-u89ZxMMh9YSI&disable-funding=credit,card"></script>
<script src="index.js"></script>
<!-- SCRIPT PAYPAL FIN -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>



              let eliminaModal= document.getElementById('eliminaModal')
              eliminaModal.addEventListener('show.bs.modal', function(event){
                //con el button traeremos el idproducto
                let button = event.relatedTarget
                let idproducto = button.getAttribute('data-bs-id')
                let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
                buttonElimina.value = idproducto
              })




      function actualizaCantidad(cantidad ,idproducto){

        let url= '../clases/actualizar_carrito.php'
        let formData= new FormData()
        formData.append('action', 'agregar')
        formData.append('id_producto', idproducto)
        formData.append('cantidad', cantidad)

        fetch(url, {
          method: 'POST',
          body: formData,
          mode: 'cors'

        }).then(response => response.json())
        .then(data =>{
          if(data.ok){
            let divsubtotal = document.getElementById('subtotal_'+ idproducto)
            divsubtotal.innerHTML = data.sub //sub viene de la peticion de actualizar carrito
           
            let total = 0.00
            let list =  document.getElementsByName('subtotal[]')
            for(let i=0; i<list.length; i++){
              total+=parseFloat(list[i].innerHTML.replace(/[$.]/g,''))
            }
            total = new Intl.NumberFormat('de-DE',{
              minumunFractionDigits:3

            }).format(total)
            document.getElementById('total').innerHTML= '<?php echo MONEDA; ?>'+ total

          }
        })
      }

//aqui va la funcion para eliminar
function eliminar(){

  let botonElimina = document.getElementById('btn-elimina')
  let idproducto = botonElimina.value

let url= '../clases/actualizar_carrito.php'
let formData= new FormData()
formData.append('action', 'eliminar')
formData.append('id_producto', idproducto)


fetch(url, {
  method: 'POST',
  body: formData,
  mode: 'cors'

}).then(response => response.json())
.then(data =>{
  if(data.ok){
    location.reload()

  }
})
}


    </script>
<!-- 
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
            let elemento = document.getElementById("num_cart")
            elemento.innerHTML = data.numero
          }
        })
      }
    </script>



-->


  
  </body>
</html>