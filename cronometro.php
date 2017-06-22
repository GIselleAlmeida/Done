<?php
include("database.php");
session_start();

if ( $_SESSION["email"] != null
    && $_SESSION["username"]!= null) {

	$email = $_SESSION["email"];
	//$grupo = $_SESSION["grupo"];
  	$pdo = new PDO($database_conexao, $database_username, $database_senha);

	$query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
	$statement = $pdo->prepare($query);
	$statement->bindValue(":email",$email);
	$statement->execute();
	$grupo = $statement->fetch(\PDO::FETCH_ASSOC);
	$time = $grupo["tempo"];
	
	date_default_timezone_set('America/Manaus');
	$dateDb = new DateTime($time);
	//echo var_dump($dateDb);
	//date_default_timezone_set('America/Manaus');
	$dateAt = new DateTime(); 
	$diff_time = $dateAt->diff($dateDb);
	//echo $diff_time->i;
	if ($diff_time->h > 0 || $diff_time->i >= 5){
		if(removePiloto($email, $pdo)) echo "0:0:0";
	   if(setPiloto($email, $pdo)) echo "0:0:0";
	   else echo "0:00";

	   clearAllPiloto($pdo, $grupo["nome"]);
      //else if (setCopiloto($email, $pdo));
   } else {
   	$time = "";
   	if ($diff_time->i < 10) $time = "0".$diff_time->i;
   	else $time = $diff_time->i;
   	if ($diff_time->s < 10) $time = $time.":0".$diff_time->s;  
   	else $time = $time.":".$diff_time->s;
   	echo $time;
   }
}

function clearAllPiloto($pdo, $grupo){

	$query = "SELECT * FROM user WHERE flag_piloto = 0 AND user.fk_grupo_randori = :grupo";

 	$statement = $pdo->prepare($query);
  	$statement->bindValue(":grupo",$grupo);
  	$statement->execute();
  //	$users = $statement->fetch(\PDO::FETCH_ASSOC);
  	$flag = False;
  	while ($user = $statement->fetch(\PDO::FETCH_ASSOC)) {
  		if ($user != NULL)
  			$flag = True;
  	}

  	if ($flag == False){
  		$query = "UPDATE user SET flag_piloto = 0 WHERE user.fk_grupo_randori = :grupo";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":grupo",$grupo);      
      $statement->execute();
  	}

  	return $flag;
}

function removePiloto($email, $pdo) {
  $query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  $grupo = $statement->fetch(\PDO::FETCH_ASSOC);
  
  if ($grupo["piloto"] == $email) {
      $query = "UPDATE grupo_randori SET piloto = NULL WHERE nome = :nome_grupo";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":nome_grupo",$grupo["nome"]);
  		$statement->execute();
  		return True;
  }
  return False;
}

function setPiloto($email, $pdo) {
  $query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  $grupo = $statement->fetch(\PDO::FETCH_ASSOC);
  
  if ($grupo["piloto"] == NULL && $grupo["copiloto"] == $email) {
    $query = "SELECT * FROM user WHERE EMAIL=:email"; 
    $statement = $pdo->prepare($query);
    $statement->bindValue(":email",$email);
    $statement->execute();
    $user = $statement->fetch(\PDO::FETCH_ASSOC);
    if ($user["flag_piloto"] == 0){

      $query = "UPDATE user SET flag_piloto = 1 WHERE email = :email";
      $statement = $pdo->prepare($query);
      $statement->bindValue(":email",$email);      
      $statement->execute();


      $query = "SELECT * FROM user WHERE flag_piloto = 0 AND user.fk_grupo_randori = :grupo ORDER BY user.username ASC";

      $statement = $pdo->prepare($query);
      $statement->bindValue(":grupo",$grupo["nome"]);
      $statement->execute();
      //  $users = $statement->fetch(\PDO::FETCH_ASSOC);
      $userCop = $statement->fetch(\PDO::FETCH_ASSOC);
      if ($userCop != NULL) {
        date_default_timezone_set('America/Manaus');
        $date = date('Y-m-d H:i:s');

        $query = "UPDATE grupo_randori SET piloto = :email, tempo = :data, resposta=:resposta, copiloto=:cop WHERE nome = :nome_grupo";
        $statement = $pdo->prepare($query);
        $statement->bindValue(":email",$grupo["copiloto"]);
        $statement->bindValue(":nome_grupo",$grupo["nome"]);
        $statement->bindValue(":resposta",$grupo["resposta"]);
        $statement->bindValue(":data",$date);
        $statement->bindValue(":cop",$userCop["email"]);              
        $statement->execute();
      }

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
      $statement->bindValue(":email",$user["email"]);
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

function getDuration($pdo) {
      $query = "SELECT * FROM experimento WHERE id_experimento=1";
 
      $statement = $pdo->prepare($query);
      $statement->execute();
      $experimento = $statement->fetch(\PDO::FETCH_ASSOC);
      $duration = $experimento["duration_randori"];
      return $duration;
}