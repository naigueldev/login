<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Sistema login</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
    integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  </head>

  <body>
    <?php
    //Si ya se ha pulsado el boton enviar
    if(isset($_POST["enviar"])){
    	try{
    		//Datos de conexion
    		$base=new PDO("mysql:host=localhost; dbname=pruebas", "root", "");
    		//el objeto conexion  llama a setAttribute
    		$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		//instruccion SQL
    		$sql="SELECT * FROM USUARIOS_PASS WHERE USUARIOS=:login AND PASSWORD=:password";
    		//preparar instruccion
    		$resultado=$base->prepare($sql);
    		//rescatar login y password
    		$login=htmlentities(addslashes($_POST["login"]));
    		$password=htmlentities(addslashes($_POST["password"]));
    		//identificar cada cuadro de texto con su marcador
    		$resultado->bindValue(":login", $login);
    		$resultado->bindValue(":password", $password);
    		//ejecutar sentencia SQL
    		$resultado->execute();
    		//en el caso de que el usuario exista nos devolvera 1. En caso contrario 0
    		$numero_registro=$resultado->rowCount();

    		//Condicional para entrar o no entrar
    		if($numero_registro != 0){
    			//iniciar sesion para el usuario logueado
    			session_start();
    			//almacenar en la variable superglobal el nombre del usuario
    			$_SESSION["usuario"]=$_POST["login"];

    			}
    		else{
          echo "Error. Usuario o contraseña incorrectos";
    			}

    	}catch(Exception $e){
    			die("Error: " . $e->getMesssage());
    		}
    }

    ?>
    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <br>
            <li><a href="http://jjmontalban.com" target="_blank">ABOUT</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Sistema login</h3>
      </div>
    </div>

    <?php

      //Si no se ha iniciado sesion entonces mostrar formulario
      if(!isset($_SESSION["usuario"])){
        include("formulario.php");

      }else{
        echo "Usuario: " . $_SESSION["usuario"];
      }

     ?>

    <div class="container">
       <div class="col-md-4 col-md-offset-4">
         <div class="jumbotron">

               <h2 class="form-signin-heading">CONTENIDO DE LA WEB</h2>

         </div> <!-- /container -->
       </div>
     </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

  </body>
</html>
