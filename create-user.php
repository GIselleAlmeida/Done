<?php
include("database.php");

$email = $_POST["email"];
$username = $_POST["username"];
$senha = $_POST["senha"];

$pdo = new PDO($database_conexao, $database_username, $database_senha);

$query = "INSERT INTO user (email, username, senha, randori_semaforo, flag_piloto, flag_copiloto) VALUES (:email,:username,:senha, 0, 0, 0);";
			
$statement = $pdo->prepare($query);
$statement->bindValue(":email",$email);
$statement->bindValue(":username",$username);
$statement->bindValue(":senha",$senha);
$statement->execute();

header("location:login.php");
?>