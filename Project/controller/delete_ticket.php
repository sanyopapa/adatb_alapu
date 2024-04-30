<?php
if (!isset($_SESSION)) {
    session_start();
}
    $tipus = $_POST['tipus'];
    include("connection.php");
    $problems = array();
    // Prepare the delete statement
    $query = "DELETE FROM jegy WHERE tipus = :tipus";

    $stmt = oci_parse($con, $query);
    oci_bind_by_name($stmt, ":tipus", $tipus);
    $siker = oci_execute($stmt);

    // Check if the delete was successful
    
    $problems['deleted']="Sikeres törlés!";
    $_SESSION["message"] = $problems;
    header("Location: ../view/ticketsearch.php");

?>
