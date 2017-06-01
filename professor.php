<?php 
include("database.php");

$pdo = new PDO($database_conexao, $database_username, $database_senha);

$query = "SELECT * FROM experimento WHERE id_experimento=1"; 
$statement = $pdo->prepare($query);
$statement->execute();
$experimento = $statement->fetch(\PDO::FETCH_ASSOC);
if ($experimento["randori_semaforo"] == 1) {
	$html_string = file_get_contents("professor.html");
   $html = str_replace('class="btn btn-warning btn-lg">Iniciar</button>', 'class="btn btn-warning btn-lg">Habilitado</button>', $html_string);
 	echo $html;
} else {
	$html_string = file_get_contents("professor.html");
   $html = str_replace('class="btn btn-warning btn-lg">Iniciar</button>', 'class="btn btn-warning btn-lg">Desabilitado</button>', $html_string);
 	echo $html;

  	}

?>