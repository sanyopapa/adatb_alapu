<?php 
if(!isset($_SESSION)){session_start();}
include("connection.php");
echo $_POST['csaladnev'];
$_SESSION["akt_csaladnev"]=$_POST['csaladnev'];
$_SESSION["akt_szemelynev"]="";
$_SESSION["akt_szemelynev_id"]= "";
header('location: myprofile.php');
?>