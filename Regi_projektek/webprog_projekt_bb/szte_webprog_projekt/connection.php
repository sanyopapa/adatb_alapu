<?php
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "users_db";

	if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname))
	{
		die("Connection failed");
	}
?>