<?php 
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
	header("location: log.php");
	exit;
}
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	if ($_SESSION["permissao"]<10){
		header("location: ausuario.php");
		exit;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Área de Administração -- Abpee</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
	</head>
	<body>
		
		<nav class="navbar navbar-expand-md navbar-light  bg-light">
			<div class="navbar-header">
				<a class="navbar-brand" href="#"  style="color: lightgreen; font-weight: 900;">Abpee</a>
			</div>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ">
				  <li class="nav-item active "><a href="#">Home</a></li>
				  <li class="nav-item"><a href="logout.php" class="nav-link"><span class="fas fa-power-off"></span>Sair</a></li>
				</ul>
			</div>
		</nav>
       
        <div class="container">
			<div class="row">
				<div class="col-md-8">
					<h2 class="">Meus Documentos</h2>
					<a href="rel/recibo.php" target="_self">Emitir Recibo de quitação</a>
					<br>
					<a href="" target="_self">Emitir Certificado de Acesso</a>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-8">
					<h2 class="">Modificar informações de pagamentos</h2>
					<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text fas fa-search" id="basic-addon1"></span>
							</div>
							<input class="form-control" type="text" name="chave" maxlength="100" placeholder="Busque pelo e-mail" required>
							<div class="input-group-append">
								<input class="btn btn-sm btn-primary" type="submit" value="Buscar" name="subPgt">
							</div>
						</div>
					</form>
				</div>
				<br><br>
				<?php
					if($_SERVER["REQUEST_METHOD"] == "POST"){
						require_once "script/conf.php";
						$sql = ("SELECT id, user_login, display_name, user_email, ultimo_pgto, ultimo_recibo_quite FROM abpee03.wp_users WHERE user_email = ?");
						if($stmt = $mysqli->prepare($sql)){
						$stmt->bind_param("s", $k);
						$k = $_POST["chave"];
						if($stmt->execute()){
							$stmt->store_result();
							if($stmt->num_rows >= 1){
								$stmt->bind_result($id, $login, $nome, $email, $dt_pagamento,$dt_recibo);
								echo "<table class=\"table table-hover\">";
								echo "<thead><tr><td>Login</td><td>Nome</td><td>E-mail</td><td>Data último pagamento</td><td>Último recibo emitido</td><td>Ações</td></tr></thead><tbody>";
								while ($stmt->fetch()){ //&& ($id != $_SESSION["id"])
									echo "<tr>";
									echo "<td>" . $login . "</td>";
									echo "<td>" . $nome . "</td>";
									echo "<td>" . $email . "</td>";
									echo "<td>" . $dt_pagamento . "</td>";
									echo "<td>" . $dt_recibo . "</td>";
									echo "<td><a class=\"btn btn-sm btn-dark\" type=\"submit\" href=\"script/at.php/?dest=" . $id . "\" target=\"rPg\">Marcar como pago</a> </td>";
									echo "</tr>";
								}
								echo "</tbody></table>";
							}
							else{
								echo "<h2>Nenhum foi encontrado</h2>";
							}
						}
						else{
							echo "<h2>Falha na recuperação dos dados. Tente mais tarde.</h2>";
						}
					}
					$stmt->close();
					$mysqli->close();
				}
			?>
			</div>
			<!-- <iframe name="rPq"></iframe> -->
			<iframe name="rPg" class="col-md-8" frameborder="0"></iframe>
			<hr>
			<div class="row">
				<div class="col-md-8">
					<h2>Assinatura dos documentos</h2>
					<br>
					<form action="script/upas.php" method="post" enctype="multipart/form-data" target="rUp">
						<div class="input-group">
							
							<div class="input-group-prepend">
								<span class="input-group-text" id="img-upl">Selecione imagem para enviar</span>
							</div>
							<input class="form-control" type = "file" name = "fileToUpload" >
						</div>
							<input class="btn btn-sm btn-primary" type="submit" value="Enviar assinatura" name="uplAss">
						
					</form>
				</div>
			</div>
			<iframe name="rUp" class="col-md-8" frameborder="0"></iframe>
		</div>
	</body>
</html>
