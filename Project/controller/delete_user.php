<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	
	if(isset($_SESSION["user_name"])){
		var_dump($_SESSION["user_name"]);
		$user_name = $_SESSION["user_name"];
		$query = "DELETE FROM felhasznalo WHERE email = '$user_name'";

		$stmt = oci_parse($con, $query);
		oci_execute($stmt);
		var_dump($stmt);

		oci_free_statement($stmt);
		session_unset();
		session_destroy();
		header('location: ../index.php');
		die;
	}
	else{
		header('location: ../index.php');
		die;
	}
?>