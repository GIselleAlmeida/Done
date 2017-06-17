<?php
include("database.php");
session_start();

if ( $_SESSION["email"] != null
    && $_SESSION["username"]!= null) {
  	
  	$email = $_SESSION["email"];
  	$pdo = new PDO($database_conexao, $database_username, $database_senha);
  	$query = "UPDATE user SET randori_semaforo = 1 WHERE user.email = '".$email."'";
	$statement = $pdo->prepare($query);
	$statement->execute();

  	if (!getSemaforoProfessor($email, $pdo) || !getSemaforoGrupo($email, $pdo)) {
    	$html_string = file_get_contents("randori-home.html");
   	$html = str_replace('<a href="logout.php">logout</a>', '<a href="logout.php">logout ('.$_SESSION["username"].')</a>', $html_string);
 	   echo $html; 		
 	}else {
      if(setPiloto($email, $pdo));
      else if (setCopiloto($email, $pdo));
    	
      header("location:randori-oficial.php");
	}
} else {
   header("location:login.php");
}

/*function setPiloto($email, $pdo) {
  $query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  $grupo = $statement->fetch(\PDO::FETCH_ASSOC);
  
  if ($grupo["piloto"] == NULL) {
    $query = "SELECT * FROM user WHERE EMAIL=:email"; 
    $statement = $pdo->prepare($query);
    $statement->bindValue(":email",$email);
    $statement->execute();
    $user = $statement->fetch(\PDO::FETCH_ASSOC);
    if ($user["flag_piloto"] == 0){
      $query = "UPDATE grupo_randori SET piloto = :email WHERE nome = :nome_grupo";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":email",$email);
      $statement->bindValue(":nome_grupo",$grupo["nome"]);      
      $statement->execute();

      $query = "UPDATE user SET flag_piloto = 1 WHERE email = :email";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":email",$email);      
      $statement->execute();
      return True;
    }
    return False;
  }
  else return False;
}*/
function setPiloto($email, $pdo) {
  $query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  $grupo = $statement->fetch(\PDO::FETCH_ASSOC);
  
  if ($grupo["piloto"] == NULL && $grupo["copiloto"] == NULL) {
    $query = "SELECT * FROM user WHERE user.fk_grupo_randori = :grupo AND flag_piloto = 0 ORDER BY user.username ASC"; 
    $statement = $pdo->prepare($query);
    $statement->bindValue(":grupo",$grupo["nome"]);
    $statement->execute();
    $user = $statement->fetch(\PDO::FETCH_ASSOC);
    if ($user["flag_piloto"] == 0){

      date_default_timezone_set('America/Manaus');
      $date = date('Y-m-d H:i:s');

      $query = "UPDATE grupo_randori SET piloto = :email, tempo = :data  WHERE nome = :nome_grupo";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":email",$user["email"]);
      $statement->bindValue(":nome_grupo",$grupo["nome"]);
      $statement->bindValue(":data",$date);      
      $statement->execute();

      $query = "UPDATE user SET flag_piloto = 1 WHERE email = :email";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":email",$user["email"]);      
      $statement->execute();
      return True;
    }
    return False;
  }
  else return False;
}

function setCopiloto($email, $pdo) {
  $query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  $grupo = $statement->fetch(\PDO::FETCH_ASSOC);
  
  if ($grupo["copiloto"] == NULL) {
    $query = "SELECT * FROM user WHERE user.fk_grupo_randori = :grupo AND flag_piloto = 0 AND flag_copiloto = 0 ORDER BY user.username ASC"; 
    $statement = $pdo->prepare($query);
    $statement->bindValue(":grupo",$grupo["nome"]);
    $statement->execute();
    $user = $statement->fetch(\PDO::FETCH_ASSOC);
    if ($user["flag_copiloto"] == 0){
      $query = "UPDATE grupo_randori SET copiloto = :email WHERE nome = :nome_grupo";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":email",$user["email"]);
      $statement->bindValue(":nome_grupo",$grupo["nome"]);      
      $statement->execute();

      $query = "UPDATE user SET flag_copiloto = 1 WHERE email = :email";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":email",$user["email"]);      
      $statement->execute();
      return True;
    }
    return False;
  }
  else return False;
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