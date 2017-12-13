<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>CRUD LIST LOGIN</title>
	<link rel="stylesheet" href="css/estilos.css">
</head>
<body>
	<div class="container">
		<form action="index.php" method="post">	
			<label for="usu">Usuario:</label><br/>
			<input class="form-control" type="text" name="txtlogin" required="true"><br/>
			<label for="pass">Password:</label><br/>
			<input class="form-control" type="password" name="txtpass" required="true"><br/>
					
			<input type="submit" class="btn btn-primary" value="Logar">	
		</form>
	<br>
		<div class="msg" id="msg">
					
		</div>
	</div>
	
</body>
</html>

<?php
	if(isset($_POST['txtpass'])) 
	{
		session_start();
		$mysqli = new mysqli("localhost", "root", "", "users") or die ("Error de conexion porque: ".$mysqli->connect_errno);
		if (mysqli_connect_errno()) 
		{
	    	printf("Falha na conexão", mysqli_connect_error());
	   		exit();
		}

		$login = $mysqli->real_escape_string($_POST['txtlogin']);	
		$pass = $mysqli->real_escape_string($_POST['txtpass']);
		
		$resultado = $mysqli->query("SELECT * FROM bdlogin WHERE login='$login' and pass='$pass' and activo!=0");
		$valida=$resultado->num_rows;
		if($valida != 0)
		{
			$datosUsu = $resultado->fetch_row();
			$_SESSION['nome'] = $datosUsu[2];
			$_SESSION['perfil'] = $datosUsu[3];				
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=list.php'>";
		}
		else
		{
			echo 
			"<script> 
				var textnode = document.createTextNode('Usuario ou Password esta errado');
				document.getElementById('msg').appendChild(textnode);
			</script>";
			
		}	
	}
?>
