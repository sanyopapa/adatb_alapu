<?php
if (!isset($_SESSION)) {
    session_start();
}
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $vonatszam = $_POST['vonatszam'];
    $honnan = $_POST['honnan'];
    $hova = $_POST['hova'];
    $indulasi_ido = DTLToStr($_POST['indulasi_ido']);
    $menetido = DTLToStr($_POST['menetido']);
    $vonattipus = $_POST['vonattipus'];

    $problems = array();

    if (empty($vonatszam) || !is_numeric($vonatszam)) {
        $problems['vonatszam'] = 'A vonatszámot meg kell adni!';
    }
    if (strlen($honnan) == 0) {
        $problems['honnan'] = 'Az indulási helyet meg kell adni!';
    }
    if (strlen($hova) == 0) {
        $problems['hova'] = 'A célhelyet meg kell adni!';
    }
    if (!empty($honnan)) {
        $query = "SELECT * FROM Allomas WHERE nev = :honnan";
        $stid = oci_parse($con, $query);
        oci_bind_by_name($stid, ':honnan', $honnan);
        oci_execute($stid);
        if (!oci_fetch($stid)) {
            $problems['honnan'] = 'Az indulási hely nem található!';
        }
    }

    if (!empty($hova)) {
        $query = "SELECT * FROM Allomas WHERE nev = :hova";
        $stid = oci_parse($con, $query);
        oci_bind_by_name($stid, ':hova', $hova);
        oci_execute($stid);
        if (!oci_fetch($stid)) {
            $problems['hova'] = 'A célhely nem található!';
        }
    }
    if (empty($indulasi_ido)) {
        $problems['indulasi_ido'] = 'Az indulási időt meg kell adni!';
    }
    if (empty($menetido)) {
        $problems['menetido'] = 'A menetidőt meg kell adni!';
    }
    if (strlen($vonattipus) == 0) {
        $problems['vonattipus'] = 'A vonattípust meg kell adni!';
    }

    if (count($problems) == 0) {
        // Ellenőrzés, hogy a vonatszám már létezik-e
        $query = "SELECT * FROM jarat WHERE vonatszam = :vonatszam";
        $stid = oci_parse($con, $query);
        oci_bind_by_name($stid, ':vonatszam', $vonatszam);
        oci_execute($stid);
        if (oci_fetch($stid)) {
            // Ha létezik, akkor frissítjük az adatokat
            $query = "UPDATE jarat SET honnan = :honnan, hova = :hova, indulasi_ido = TO_TIMESTAMP(:indulasi_ido, 'YYYY-MM-DD HH24:MI:SS'), menetido = TO_TIMESTAMP(:menetido, 'YYYY-MM-DD HH24:MI:SS'), vonattipus = :vonattipus WHERE vonatszam = :vonatszam";
            $stid = oci_parse($con, $query);
            oci_bind_by_name($stid, ':honnan', $honnan);
            oci_bind_by_name($stid, ':hova', $hova);
            oci_bind_by_name($stid, ':indulasi_ido', $indulasi_ido);
            oci_bind_by_name($stid, ':menetido', $menetido);
            oci_bind_by_name($stid, ':vonattipus', $vonattipus);
            oci_bind_by_name($stid, ':vonatszam', $vonatszam);
            oci_execute($stid);

            // Sikeres frissítés esetén átirányítás
            $problems['success'] = "Sikeres módosítás!";
            $_SESSION["message"] = $problems;
            header("Location: ../view/menetrendsearch.php");
            oci_close($con);
            die;
        } else {
            $problems['vonatszam'] = 'Ez a vonatszám még nem létezik, kérlek új járat létrehozásával próbálkozz.';
        }
    }

    // Hibák esetén visszairányítás a felhasználóhoz
    $_SESSION["message"] = $problems;

    header('location: ../view/menetrendsearch.php');
    oci_close($con);
    die;
} else {
    // Ha nem POST kérés érkezett, visszairányítás
    header("Location: ../view/menetrendsearch.php");
    oci_close($con);
}
?>
