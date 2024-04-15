<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	
	if(isset($_SESSION["user_name"])){
		$user_name = $_SESSION["user_name"];
		$query = "delete from users where user_name = '$user_name'";
		mysqli_query($con, $query);
		
		session_unset();
		session_destroy();
		header('location: index.php');
		die;
	}
	else{
		header('location: index.php');
		die;
	}
?>