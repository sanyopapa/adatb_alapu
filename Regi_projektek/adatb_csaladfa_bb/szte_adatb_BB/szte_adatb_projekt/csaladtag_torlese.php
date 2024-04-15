<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	
	if(isset($_SESSION["user_name"])){
		$torlendo = $_POST["szemelynev"];
        echo $torlendo;
        $tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_szemelyek';
		$query = "delete from $tabla_neve where nev = '$torlendo'";
		mysqli_query($con, $query);
		header('location: myprofile.php');
	}
	else{
		header('location: index.php');
		die;
	}
?>