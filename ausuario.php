<?php 
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
	header("location: log.php");
	exit;
}
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	if ($_SESSION["permissao"]==10){
		header("location: aadm.php");
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
			<div class="container">
				<div class="">
					<h2 class="panel-title">Meus Documentos</h2>
				</div>
				<div class="">
					<a href="rel/recibo.php" target="_self">Emitir Recibo de quitação</a>
					<br>
					<a href="" target="_self">Emitir Certificado de Acesso</a>
				</div>
			</div>
		</div>
	</body>
</html>
