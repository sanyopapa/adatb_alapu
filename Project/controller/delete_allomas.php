<?php
if (!isset($_SESSION)) {
    session_start();
}

$nev = $_POST['nev'];
include("connection.php");
$problems = array();

// Prepare the delete statement
$query = "DELETE FROM allomas WHERE nev = :nev";

$stmt = oci_parse($con, $query);
oci_bind_by_name($stmt, ":nev", $nev);
$siker = oci_execute($stmt);

// Check if the delete was successful
if ($siker) {
    $problems['success'] = "Sikeres törlés!";
} else {
    $problems['deleted'] = "Sikertelen törlés!";
}

$_SESSION["message"] = $problems;
header("Location: ../view/allomassearch.php");
?>
