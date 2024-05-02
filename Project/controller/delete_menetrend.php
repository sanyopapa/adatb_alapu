<?php
if (!isset($_SESSION)) {
    session_start();
}
include("connection.php");

$vonatszam = $_POST['vonatszam'];
$problems = array();

// Prepare the delete statement
$query = "DELETE FROM jarat WHERE vonatszam = :vonatszam";

$stmt = oci_parse($con, $query);
oci_bind_by_name($stmt, ":vonatszam", $vonatszam);
$siker = oci_execute($stmt);

// Check if the delete was successful
if ($siker) {
    $problems['success'] = "Sikeres törlés!";
} else {
    $problems['deleted'] = "Hiba történt a törlés során!";
}

$_SESSION["message"] = $problems;
header("Location: ../view/menetrendsearch.php");
?>
