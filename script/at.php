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
	if(isset($_GET["dest"])){
		require_once "conf.php";
		$sql = "UPDATE abpee03.wp_users SET ultimo_pgto = '" . date("Y-m-d H:i:s") . "' WHERE id = ?";
		if($stmt = $mysqli->prepare($sql)){
			$stmt->bind_param("i",$id);
			$id = $_GET["dest"];
			if($stmt->execute()){
				echo "<h3>Atualizado!</h3>";
			}
			else{
				echo "<h3>Erro ao atualizar!</h3>";
			}
		}else{echo "<h3>Erro no preparo!</h3>";}
		$stmt->close();
		$mysqli->close();
	}
	else{
		echo "<h1>Acesso não autorizado!</h1>";
		header("location: log.php",true, 503);
	}
}
?>
