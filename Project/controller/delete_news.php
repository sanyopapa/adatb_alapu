<?php
$name = $_POST['name'];
include("connection.php");

// Prepare the delete statement
$query = "DELETE FROM hir WHERE hirid = :nam";

$stmt = oci_parse($con, $query);
oci_bind_by_name($stmt, ":nam", $name);
$siker = oci_execute($stmt);
// Check if the delete was successful
if ($siker) {
    echo "Felhasználó sikeresen törölve.";
    header("Location: ../view/newssearch.php");
} else {
    echo "No rows deleted.";
}
?>