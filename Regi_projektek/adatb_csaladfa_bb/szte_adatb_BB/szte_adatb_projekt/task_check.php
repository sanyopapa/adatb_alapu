<?php 
if(!isset($_SESSION)){session_start();}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $_SESSION["tol"]=$_POST["tol"];
    $_SESSION["ig"]=$_POST["ig"];

    $problems=array();
    if ($_SESSION["tol"]>= $_SESSION["ig"]) {
        $problems["date"]="Fordítsd meg a két dátumot!";
        $_SESSION["message"] = $problems;
    }
    header("location: tasks.php");
}
?>