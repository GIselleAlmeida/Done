<?php
include("database.php");

//var_dump($_POST);
$flag_sucess = false;

$nome_grupo = $_POST["grupo"];
$pdo = new PDO($database_conexao, $database_username, $database_senha);
$query = "INSERT INTO grupo_randori (nome) VALUES ('".$nome_grupo."');";
$statement = $pdo->prepare($query);

$flag_sucess = $statement->execute();


foreach ($_POST as $key => $value) {
	if ($key != "grupo")  {
		//UPDATE `user` SET `fk_grupo_randori` = 'grupoteste' WHERE `user`.`email` = 'teste@teste.com';
	//	echo "nome grp: ".$nome_grupo . " value: " . $value . " key: " . $key;
		$query = "UPDATE user SET fk_grupo_randori = '".$nome_grupo."' WHERE user.email = '".$value."'";
		//echo "<br/>";
		//echo $query;
		//echo "<br/>";
		$statement = $pdo->prepare($query);
		$flag_sucess = $statement->execute();
	} else {
		break;
	}
}		

if ($flag_sucess)
	header("location:home.php");

?>