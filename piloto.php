<?php
include("database.php");
session_start();

if ( $_SESSION["email"] != null
    && $_SESSION["username"]!= null) {

	$email = $_SESSION["email"];
	//$grupo = $_SESSION["grupo"];
  	$pdo = new PDO($database_conexao, $database_username, $database_senha);

	$query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
	$statement = $pdo->prepare($query);
	$statement->bindValue(":email",$email);
	$statement->execute();
	$grupo = $statement->fetch(\PDO::FETCH_ASSOC);
	$piloto = $grupo["piloto"];
	if($piloto != null) {
		echo "0:".$piloto;
	} else echo "0";
	
}
?>