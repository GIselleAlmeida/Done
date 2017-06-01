<?php
include("database.php");

session_start();

//echo var_dump($_SESSION);

if ( $_SESSION["email"] != null
    && $_SESSION["username"]!= null) {
  	
  	$email = $_SESSION["email"];
  	$pdo = new PDO($database_conexao, $database_username, $database_senha);
  	if (!getSemaforoProfessor($email, $pdo)) {
  		echo "Aguarde o professor liberar o experimento";
  	} else if (!getSemaforoGrupo($email, $pdo)) {
  		echo "Aguarde os demais alunos do grupo iniciarem Randori";
  	} else {
    //echo $_SESSION["username"];
    /*$html_string = file_get_contents("randori.html");
    $html = str_replace('<a href="logout.php">logout</a>', '<a href="logout.php">logout ('.$_SESSION["username"].')</a>', $html_string);
    echo $html;*/
      //header("location:randori-oficial.php"); 		
  	 echo "randori-oficial.php";
    }
} else {
    header("location:login.php");
}

function getSemaforoProfessor($email, $pdo) {
  $query = "SELECT * FROM experimento WHERE id_experimento=1";
 
  $statement = $pdo->prepare($query);
  $statement->execute();
  $experimento = $statement->fetch(\PDO::FETCH_ASSOC);
	if ($experimento["randori_semaforo"] == 1)
    return True;
  else return False;
}

function getSemaforoGrupo($email, $pdo) {

  $query = "SELECT * FROM user WHERE user.fk_grupo_randori = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  
  //$user = $statement->fetch(\PDO::FETCH_ASSOC);
  while ($user = $statement->fetch(\PDO::FETCH_ASSOC)) {
    $_SESSION["grupo"] = $user["fk_grupo_randori"];
    if ($user["randori_semaforo"] == 0)
      return False;
  }
	return True;
}
?>