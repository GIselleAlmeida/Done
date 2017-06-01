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

session_unset($_SESSION["email"]);
session_unset($_SESSION["username"]);
session_destroy();
header("location:login.php");


?>