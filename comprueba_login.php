<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>login</title>


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
			//redirecion
			header("location:usuarios_registrados1.php");
			}
		else{
			header("location:login.php");
			}

	}catch(Exception $e){
			die("Error: " . $e->getMesssage());
		}

?>



</body>
</html>
