<?php
define('DB_SERVER', 'mysql.abpee.net');
define('DB_USERNAME', 'abpee03');
define('DB_PASSWORD', 'manalu3filhos');
define('DB_NAME', 'abpee03');
 
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($mysqli === false){
    die("ERRO: Falha de conexão. " . $mysqli->connect_error);
}
?>
