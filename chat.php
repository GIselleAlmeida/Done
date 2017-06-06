<?php
include("database.php");
session_start();

$email = $_SESSION["email"];

//$answer = $_POST["answer"];
//echo "teste";
//echo var_dump($_POST);
//echo $email;
if ($_POST != null && $_POST["msg"]!= "" && $email !=null) {
	date_default_timezone_set('America/Manaus');
	$date = date("Y-m-d H:i:s"); 

	$msg = $_POST["msg"];
	$pdo = new PDO($database_conexao, $database_username, $database_senha);

  	$query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 	$pdo = new PDO($database_conexao, $database_username, $database_senha);
  	$statement = $pdo->prepare($query);
  	$statement->bindValue(":email",$email);
  	$statement->execute();
  	$grupo = $statement->fetch(\PDO::FETCH_ASSOC);
  	//echo $grupo["resposta"];


	$query = "INSERT INTO chat (fk_grupo,fk_user,msg,timestampMsg) VALUES (:grupo, :user, :msg, :timestampmsg)";
	$statement = $pdo->prepare($query);
	$statement->bindValue(":grupo",$grupo["nome"]);
	$statement->bindValue(":user",$email);
	$statement->bindValue(":msg",$msg);
	$statement->bindValue(":timestampmsg",$date);		      
	$statement->execute();

	echo "ok";
} else {
  $query = "SELECT * FROM chat WHERE chat.fk_grupo = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email) ORDER BY timestampMsg ASC";
 	$pdo = new PDO($database_conexao, $database_username, $database_senha);
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  //$conversas = $statement->fetch(\PDO::FETCH_ASSOC);
  while ($conversa = $statement->fetch(\PDO::FETCH_ASSOC)) {
  	$query = "SELECT * FROM user WHERE EMAIL=:email";
	$st = $pdo->prepare($query);
  	$st->bindValue(":email",$conversa["fk_user"]);
  	$st->execute();
	$user = $st->fetch(\PDO::FETCH_ASSOC);

  	echo $user["username"]."$".$conversa["msg"]."!";

  }

}


?>