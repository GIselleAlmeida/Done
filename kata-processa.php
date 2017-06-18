<?php
include("database.php");

$email = $_POST["email"];

if($email != "" || $email != NULL) {
$pdo = new PDO($database_conexao, $database_username, $database_senha);

$query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
$statement = $pdo->prepare($query);
$statement->bindValue(":email",$email);
$statement->execute();
$grupo = $statement->fetch(\PDO::FETCH_ASSOC);


$query = "UPDATE grupo_randori SET piloto = :email WHERE nome = :nome_grupo";
$statement = $pdo->prepare($query);
$statement->bindValue(":nome_grupo",$grupo["nome"]);
$statement->bindValue(":email",$email);
$statement->execute();

}

header("location:kata.php");
?>