<?php
include("database.php");

$pdo = new PDO($database_conexao, $database_username, $database_senha);

$query = "SELECT * FROM experimento WHERE id_experimento = 1 ";
$statement = $pdo->prepare($query);
$statement->execute();
$experimento = $statement->fetch(\PDO::FETCH_ASSOC);

if($experimento["randori_semaforo"] == 1)
	$query = "UPDATE experimento SET randori_semaforo = 0 WHERE experimento.id_experimento = 1";
else
		$query = "UPDATE experimento SET randori_semaforo = 1 WHERE experimento.id_experimento = 1";

$statement = $pdo->prepare($query);
$statement->execute();

header("location:professor.php");
?>