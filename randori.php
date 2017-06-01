<?php

session_start();

if ( $_SESSION["email"] != null
    && $_SESSION["username"]!= null) {
  	
  	if ( $_SESSION["grupo"] == null) {
    	$html_string = file_get_contents("randori-home.html");
   	$html = str_replace('<a href="logout.php">logout</a>', '<a href="logout.php">logout ('.$_SESSION["username"].')</a>', $html_string);
 	   echo $html; 		
 	}else {
    	header("location:randori-oficial.php");
	}
} else {
   header("location:login.php");
}

?>