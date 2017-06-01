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

      if(setPiloto($email, $pdo));
      else if (setCopiloto($email, $pdo));    
 		  //else  
  	 echo "randori-oficial.php";
    }
} else {
    header("location:login.php");
}

function setPiloto($email, $pdo) {
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
}

function setCopiloto($email, $pdo) {
  $query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  $grupo = $statement->fetch(\PDO::FETCH_ASSOC);
  
  if ($grupo["copiloto"] == NULL) {
    $query = "SELECT * FROM user WHERE EMAIL=:email"; 
    $statement = $pdo->prepare($query);
    $statement->bindValue(":email",$email);
    $statement->execute();
    $user = $statement->fetch(\PDO::FETCH_ASSOC);
    if ($user["flag_copiloto"] == 0){
      $query = "UPDATE grupo_randori SET copiloto = :email WHERE nome = :nome_grupo";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":email",$email);
      $statement->bindValue(":nome_grupo",$grupo["nome"]);      
      $statement->execute();

      $query = "UPDATE user SET flag_copiloto = 1 WHERE email = :email";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":email",$email);      
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