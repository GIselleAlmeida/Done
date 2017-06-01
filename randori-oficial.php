<?php
include("database.php");
session_start();

if ( $_SESSION["email"] != null
    && $_SESSION["username"]!= null) {
 
 	$email = $_SESSION["email"];
  	$pdo = new PDO($database_conexao, $database_username, $database_senha);

  	if (!getSemaforoProfessor($email, $pdo) || !getSemaforoGrupo($email, $pdo)) {
 		 header("location:randori.php");
 	}else {
		$html_string = file_get_contents("randori.html");
   	$html = str_replace('<a href="logout.php">logout</a>', '<a href="logout.php">logout ('.$_SESSION["username"].')</a>', $html_string);
  
 /* 		$query = "SELECT * FROM experimento WHERE id_experimento=1";
 
  		$statement = $pdo->prepare($query);
  		$statement->execute();
  		$experimento = $statement->fetch(\PDO::FETCH_ASSOC);
		  $questao = $experimento["questao"]; 	   
  */	
      $questao = getQuestao($email, $pdo);
  	  $html = str_replace("<h4>questao</h4>", "<h4>".$questao."</h4>", $html);
 	    
      $str_piloto = 'p1l0t0';
      $str_copiloto = 'copiloto';
      
      $grupo = getGrupo($email, $pdo);

      $html = str_replace($str_piloto, $grupo["piloto"], $html);
      $html = str_replace($str_copiloto, $grupo["copiloto"], $html);      

      $duration = getDuration($email, $pdo);
      $str_cronometo = "$";
      $html = str_replace($str_cronometo, $duration, $html);
      
      if($email == $grupo["piloto"]) {
        $field = "<fieldset disabled>";
        $fieldaux = "</fieldset>";
        $html = str_replace($field, "", $html);
        $html = str_replace($fieldaux, "", $html);
        echo $html;
      }
      else {
        $arquivo_default = "default_principal";
        $html = str_replace($arquivo_default, "dft", $html); 
        echo $html;
      }
    }
		//echo "Ocorreu algum erro fale com o professor";
} else {
   header("location:login.php");
}

function getDuration($email, $pdo) {
      $query = "SELECT * FROM experimento WHERE id_experimento=1";
 
      $statement = $pdo->prepare($query);
      $statement->execute();
      $experimento = $statement->fetch(\PDO::FETCH_ASSOC);
      $duration = $experimento["duration_randori"];
      return $duration;
}

function getQuestao($email, $pdo) {
      $query = "SELECT * FROM experimento WHERE id_experimento=1";
 
      $statement = $pdo->prepare($query);
      $statement->execute();
      $experimento = $statement->fetch(\PDO::FETCH_ASSOC);
      $questao = $experimento["questao"];
      return $questao;
}

function getGrupo($email, $pdo) {
  $query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  $grupo = $statement->fetch(\PDO::FETCH_ASSOC);
  
  return $grupo;
}

function getCopiloto($email, $pdo) {
  $query = "SELECT * FROM grupo_randori WHERE grupo_randori.nome = (SELECT user.fk_grupo_randori FROM user WHERE EMAIL=:email)";
 
  $statement = $pdo->prepare($query);
  $statement->bindValue(":email",$email);
  $statement->execute();
  $grupo = $statement->fetch(\PDO::FETCH_ASSOC);
  
  return $grupo;
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