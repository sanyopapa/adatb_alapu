<?php
	include("../controller/connection.php");

if (!$con) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Prepare and execute the SQL query
$sql = "SELECT * FROM Jarat";
$stmt = oci_parse($con, $sql);
oci_execute($stmt);

// Display the data in a table
echo "<table>";
echo "<tr><th>Vonatszam</th><th>Honnan</th><th>Hova</th><th>Indulasi_ido</th><th>Menetido</th><th>Vonattipus</th></tr>";

while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['VONATSZAM'] . "</td>";
    echo "<td>" . $row['HONNAN'] . "</td>";
    echo "<td>" . $row['HOVA'] . "</td>";
    echo "<td>" . $row['INDULASI_IDO'] . "</td>";
    echo "<td>" . $row['MENETIDO'] . "</td>";
    echo "<td>" . $row['VONATTIPUS'] . "</td>";
    echo "</tr>";
}

echo "</table>";

// Clean up resources
oci_free_statement($stmt);
oci_close($con);
?>