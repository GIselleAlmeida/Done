<?php

include("database.php");
session_start();

//echo var_dump($_SESSION);

if ($_SESSION["email"] != null
    && $_SESSION["username"]!= null) {
    //echo $_SESSION["username"];

	if(isset($_POST["grupo"])) {

		$flag = create_grupo($database_conexao, $database_username, $database_senha);
		echo $flag;
		if ($flag){
			//echo "cadastrado com sucesso";
   		$string_replace = '<h3 class="panel-title">Crie seu Grupo</h3>';
    		$new_string = '<h3 class="panel-title">CADASTRADO COM SUCESSO: '.$_POST["grupo"].'</h3>';  		
   		$html_string = file_get_contents("criar_grupo.html");
    		$html = str_replace($string_replace, $new_string, $html_string);
   		echo $html;
		} else{
			//echo "erro";
   		$string_replace = '<h3 class="panel-title">Crie seu Grupo</h3>';
    		$new_string = '<h3 class="panel-title">OCORREU ALGUM ERRO - GRUPO JÁ EXISTENTE OU EMAIL INVALIDO</h3>';  		
   		$html_string = file_get_contents("criar_grupo.html");
    		$html = str_replace($string_replace, $new_string, $html_string);
   		echo $html;
		}

	} else {
    	$html_string = file_get_contents("criar_grupo.html");
    	$html = str_replace('<a href="logout.php">logout</a>', '<a href="logout.php">logout ('.$_SESSION["username"].')</a>', $html_string);
   	echo $html;
 	}

} else {
    header("location:login.php");
}

function create_grupo ($database_conexao, $database_username, $database_senha) {
	$nome_grupo = $_POST["grupo"];
	$pdo = new PDO($database_conexao, $database_username, $database_senha);
	$query = "INSERT INTO grupo_randori (nome, randori_semaforo) VALUES ('".$nome_grupo."', 0);";
	$statement = $pdo->prepare($query);

	if($statement->execute()) {
		foreach ($_POST as $key => $value) {
			if ($key != "grupo")  {
				$query = "UPDATE user SET fk_grupo_randori = '".$nome_grupo."' WHERE user.email = '".$value."'";
				$statement = $pdo->prepare($query);
				if (!$statement->execute() || $statement->rowCount() == 0) 
					return False;
			} else {
				break;
			}
		}

		return True;
	} else 
		return False;
}
?>