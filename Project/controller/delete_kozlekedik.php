<?php
if (!isset($_SESSION)) {
    session_start();
}

// Az űrlapról érkező adatok fogadása
$allomasNev = $_POST['allomasnev'];
$vonatszam = $_POST['vonatszam'];

// Adatbázis kapcsolat létrehozása
include("connection.php");

// Hibakezelés tömb inicializálása
$problems = array();

// Prepare the delete statement
$query = "DELETE FROM Kozlekedik WHERE AllomasNev = :allomasNev AND Vonatszam = :vonatszam";

$stmt = oci_parse($con, $query);
oci_bind_by_name($stmt, ":allomasNev", $allomasNev);
oci_bind_by_name($stmt, ":vonatszam", $vonatszam);
$siker = oci_execute($stmt);

// Ellenőrizze, hogy a törlés sikeres volt-e
if ($siker) {
    $problems['deleted'] = "Sikeres törlés!";
} else {
    // Ha nem sikerült a törlés, hibaüzenetet állítunk be
    $problems['deleted'] = "A törlés nem sikerült!";
}

// Hibák üzenetének mentése a session-be
$_SESSION["message"] = $problems;

// Átirányítás a ticketsearch.php oldalra
header("Location: ../view/kozlekediksearch.php");
?>
