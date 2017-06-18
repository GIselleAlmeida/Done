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
		//$strGrupo = "0:".$piloto.":".$copiloto;
		
		$query = "SELECT * FROM user WHERE fk_grupo_randori = :grupo";
 
		$statement = $pdo->prepare($query);
		$statement->bindValue(":grupo",$grupo["nome"]);
		$statement->execute();
		$strGrupo = "";
		$pilotoUser = "";
		while ($user = $statement->fetch(\PDO::FETCH_ASSOC)) {
			if ($user["email"] == $piloto) $pilotoUser = $user["username"];		
			else $strGrupo = $strGrupo.":".$user["username"];
		}
		echo "0:".$pilotoUser.":".$strGrupo;
	} else echo "0";
	
}
?>