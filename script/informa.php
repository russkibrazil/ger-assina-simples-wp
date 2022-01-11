<?php
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
		header("location: log.php");
		exit;
	}
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		if ($_SESSION["permissao"]<10)
			header("location: ausuario.php");
		exit;
	}
	require_once "conf.php";
	$sql = ("SELECT id, user_login, display_name, user_email, ultimo_pgto, ultimo_recibo_quite FROM abpee03.wp_users WHERE user_email = ?");
	if($stmt = $mysqli->prepare($sql)){
		$stmt->bind_param("s", $k);
		$k = $_POST["chave"];
		if($stmt->execute()){
			$stmt->store_result();
			if($stmt->num_rows >= 1){
				$stmt->bind_result($id, $login, $nome, $email, $dt_pagamento,$dt_recibo);
				echo "<table>";
				echo "<tr><td>Login</td><td>Nome</td><td>E-mail</td><td>Data último pagamento</td><td>Último recibo emitido</td><td>Ações</td></tr>";
				while ($stmt->fetch()){
					echo "<tr>";
					echo "<td>" . $login . "</td>";
					echo "<td>" . $nome . "</td>";
					echo "<td>" . $email . "</td>";
					echo "<td>" . $dt_pagamento . "</td>";
					echo "<td>" . $dt_recibo . "</td>";
					echo "<td><button type=\"submit\" formaction=\"\">Marcar como pago</button> </td>";
					echo "</tr>";
				}
				echo "</table>";
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
?>
