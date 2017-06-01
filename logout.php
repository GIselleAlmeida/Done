<?php

include("database.php");

$email = $_SESSION["email"];
$pdo = new PDO($database_conexao, $database_username, $database_senha);
$query = "UPDATE user SET posicao = NULL WHERE user.email = '".$email."'";
$pdo->prepare($query);
$statement->execute();

session_start();
session_unset($_SESSION["email"]);
session_unset($_SESSION["username"]);
session_destroy();
header("location:login.php");

?>