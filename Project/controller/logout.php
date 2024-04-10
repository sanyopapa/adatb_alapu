<?php
	if(!isset($_SESSION)){session_start();}
	if(isset($_SESSION["user_name"])){
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