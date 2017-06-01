<?php
include("database.php");
session_start();

$email = $_SESSION["email"];

//$answer = $_POST["answer"];
//echo "teste";
//echo var_dump($_POST);
//echo $email;
if ($_POST != null) {
	$answer = $_POST["answer"];
	$pdo = new PDO($database_conexao, $database_username, $database_senha);
	$query = "UPDATE grupo_randori SET resposta = :resposta WHERE nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
	$statement = $pdo->prepare($query);
	$statement->bindValue(":resposta",$answer);
	$statement->bindValue(":email",$email);      
	$statement->execute();
} else {
  $query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 	$pdo = new PDO($database_conexao, $database_username, $database_senha);
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  $grupo = $statement->fetch(\PDO::FETCH_ASSOC);
  echo $grupo["resposta"];

}


?>