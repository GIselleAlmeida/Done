<?php
include("database.php");
session_start();

if ( $_SESSION["email"] != null
    && $_SESSION["username"]!= null) {
 
 	$email = $_SESSION["email"];
  	$pdo = new PDO($database_conexao, $database_username, $database_senha);

		$html_string = file_get_contents("kata.html");
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
      
      if($email == $grupo["piloto"]) {
        $field = "<fieldset disabled>";
        $fieldaux = "</fieldset>";
        $html = str_replace($field, "", $html);
        $html = str_replace($fieldaux, "", $html);
        $codemirror = '<textarea class="codemirror-textarea"></textarea>';


        $newcodemirror = '<textarea class="codemirror-textarea">'.$grupo['resposta'].'</textarea>';
        $html = str_replace($codemirror, $newcodemirror, $html);
        echo $html;
      }
      else {
        $arquivo_default = "default_principal";
        $html = str_replace($arquivo_default, "dft", $html); 
        echo $html;
      }
		//echo "Ocorreu algum erro fale com o professor";
} else {
   header("location:login.php");
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

?>