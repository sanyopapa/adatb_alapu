<?php 
if(!isset($_SESSION)){session_start();}
include("connection.php");
echo $_POST['szemelynev'];
$_SESSION["akt_szemelynev"]=$_POST['szemelynev'];
$_SESSION["akt_szemelynev_id"]=$_POST['szemelynev_id'];
header('location: myprofile.php');
?>