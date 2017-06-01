<?php
include("database.php");

$email = $_POST["email"];
$senha = $_POST["senha"];

//$database = new database();
//$pdo = $databas.connect();

$pdo = new PDO($database_conexao, $database_username, $database_senha);
$query = "SELECT * FROM user WHERE EMAIL=:email AND SENHA=:senha";
 
$statement = $pdo->prepare($query);
$statement->bindValue(":email",$email);
$statement->bindValue(":senha",$senha);
$statement->execute();
$user = $statement->fetch(\PDO::FETCH_ASSOC);

//echo var_dump($user);

if ($user) {
	session_start();
	$_SESSION["email"] = $user["email"];
	$_SESSION["username"] = $user["username"];
	//$_SESSION['expire'] = $_SESSION['start'] + (24 * 60 * 60);
	header("location:home.php");
	//echo $_SESSION["email"] . " user " . $_SESSION["username"] . " ". var_dump($_SESSION);
} else {
	header("location:login.php");
}

//session_start();
//$_SESSION["email"] = $email;
//echo "username: " . $username . " senha: " . $senha;


?>