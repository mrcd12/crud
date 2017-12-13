<!DOCTYPE html>
<meta charset="UFT-8">

<?php
	$con = mysqli_connect("localhost", "root", "", "users") or die("Erro");
	
?>

<html>

	<head>
		<meta charset="UTF-8">
		<title> Web Crud Php</title>
		<link rel="stylesheet" href="css/stile.css">
	</head>
	
	<body>
		<?php		
			
			if(isset($_FILES['arquivo'])){
				
				$extensao = strtolower(substr($_FILES['arquivo']['name'], -4));
				$novo_nome = md5(time()) . $extensao;
				$diretorio = "upload/";
				
				move_uploaded_file($_FILE['arquivo']['tem_name'], $diretorio.$novo_nome);
				
				$sql_code = "INSERT INTO bduser (arquivo) VALUE('$novo_nome')";
				if(mysqli_query($sql_code))
					echo "<script> alert('Arquivo Anexado')</script>";

				else
					echo "<script> alert('Falha ao anexar arquivo')</script>";
			
			}
		
		?>
	
		<form method="POST" action="" enctype="multiport/form-data" >
			<div class="form-group">	
				<label> <strong> Código:</strong> </label><br/>
				<input type="text" name="codigo">
			</div>

			<div class="form-group">
				<label> <strong> Nome:</strong> </label><br/>
				<input type="text" name="nome">
			</div>
			<div class="form-group">
				<label> <strong> Descrição:</strong> </label><br/>
				<input type="text" name="textt">
			</div>
			<div class="form-group">
				<label> <strong> Anexo:</strong> </label><br/>
				<input type="file" class="btn btn-insert" name="anexo">
			</div>
			</br>
				<input type="submit" class="btn btn-enter" name="insert" value="Incluir novo produto"><br/>
			
		<?php
		
			if(isset($_POST['insert'])){
				$cod = $_POST['codigo'];
				$name = $_POST['nome'];
				$desc = $_POST['textt'];
				$anex = $_POST['anexo'];
				
				$insercao = "INSERT INTO bduser (codigo, name, description, anexo) VALUES ('$cod', '$name', '$desc', '$anex')";
				
				$executar = mysqli_query($con, $insercao);
				
				if($executar){
					echo "<script>alert('produto incluso')</script>";
					echo "<script>window.open('list.php','_self')</script>";
				}
			}
		?>
		</br>
		</br>
		
		<table width="500" border="0" style="background-color:#F9F9F9;">
			<tr>
				<th>ID</th>
				<th>Código</th>
				<th>Nome</th>
				<th>Descrição</th>
				<th>Anexo</th>
				<th>Editar</th>
				<th>Apagar</th>
			</tr>
		
			<?php
				$consulta = "SELECT * FROM bduser";
				
				$executar = mysqli_query($con, $consulta);
				
				$i = 0;
				
				while($fila = mysqli_fetch_array($executar)){
					$id = $fila['id'];
					$codigo = $fila['codigo'];
					$name = $fila['name'];
					$description = $fila['description'];
					$anexo = $fila['anexo'];
				
					$i++;
				
			?>
			
			<tr align="center">
				<td><?php echo $id; ?></td>
				<td><?php echo $codigo; ?></td>
				<td><?php echo $name; ?></td>
				<td><?php echo $description; ?></td>
				<td><?php echo $anexo; ?></td>
				<td class='btn btn-insert'><a href="list.php?editar=<?php echo $id; ?>">Editar</a></td>
				<td class='btn btn-erase'><a href="list.php?apagar=<?php echo $id; ?>">Apagar</a></td>
			</tr>
			
			<?php } ?> 

		</table>
			
		
			
			<?php
				if(isset($_GET['editar'])){
					include("editar.php");
			}
		
		?>
		
		<?php
			if(isset($_GET['apagar'])){
				
				$apagar_id = $_GET['apagar'];
				
				$apagar = "DELETE FROM bduser WHERE id= $apagar_id";
				$executar = mysqli_query($con, $apagar);
				
				if($executar){
					echo "<script>alert('Apagou os dados')</script>";
					echo "<script>window.open('list.php','_self')</script>";
				}
				
			}
		?>
		
		
		
	</body>
</html>
