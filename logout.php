<?php

include("database.php");
session_start();

$email = $_SESSION["email"];
$pdo = new PDO($database_conexao, $database_username, $database_senha);

$query = "UPDATE user SET posicao = NULL WHERE user.email = '".$email."'";
$statement = $pdo->prepare($query);
$statement->execute();

$query = "UPDATE user SET randori_semaforo = 0 WHERE user.email = '".$email."'";
$statement = $pdo->prepare($query);
$statement->execute();

$query = "UPDATE user SET flag_piloto = 0 WHERE user.email = '".$email."'";
$statement = $pdo->prepare($query);
$statement->execute();

$query = "UPDATE user SET flag_copiloto = 0 WHERE user.email = '".$email."'";
$statement = $pdo->prepare($query);
$statement->execute();


$query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
$statement = $pdo->prepare($query);
$statement->bindValue(":email",$email);
$statement->execute();
$grupo = $statement->fetch(\PDO::FETCH_ASSOC);

if ($grupo["piloto"] == $email) {
	$query = "UPDATE grupo_randori SET piloto = NULL, copiloto = NULL WHERE grupo_randori.nome = '".$grupo["nome"]."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
}

if ($grupo["copiloto"] == $email) {
	$query = "UPDATE grupo_randori SET piloto = NULL, copiloto = NULL WHERE grupo_randori.nome = '".$grupo["nome"]."'";
	$statement = $pdo->prepare($query);
	$statement->execute();
}

session_unset($_SESSION["email"]);
session_unset($_SESSION["username"]);
session_destroy();
header("location:login.php");


?>