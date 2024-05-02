<?php
if (!isset($_SESSION)) {
    session_start();
}

$sznev = $_POST['sznev'];
include("connection.php");
$problems = array();

// Prepare the delete statement
$query = "DELETE FROM szerelveny WHERE sznev = :sznev";

$stmt = oci_parse($con, $query);
oci_bind_by_name($stmt, ":sznev", $sznev);
$siker = oci_execute($stmt);

// Check if the delete was successful
if ($siker) {
    $problems['success'] = "Sikeres törlés!";
} else {
    $problems['deleted'] = "Sikertelen törlés!";
}

$_SESSION["message"] = $problems;
header("Location: ../view/szerelvenysearch.php");
?>
