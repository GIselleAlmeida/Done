<?php 
include("database.php");

$pdo = new PDO($database_conexao, $database_username, $database_senha);

$query = "SELECT * FROM experimento WHERE id_experimento=1"; 
$statement = $pdo->prepare($query);
$statement->execute();
$experimento = $statement->fetch(\PDO::FETCH_ASSOC);
if ($experimento["randori_semaforo"] == 1) {

} else {

  	}

?>