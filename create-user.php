<?php
include("database.php");

$email = $_POST["email"];
$username = $_POST["username"];
$senha = $_POST["senha"];

$pdo = new PDO($database_conexao, $database_username, $database_senha);

$query = "INSERT INTO user (email, username, senha) VALUES ('".$email."','".$username."',
			'".$senha."');";
$statement = $pdo->prepare($query);
$statement->execute();

header("location:login.php");
?>