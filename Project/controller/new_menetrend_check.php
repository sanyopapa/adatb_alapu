<?php
if (!isset($_SESSION)) {
    session_start();
}

// Adatbázis kapcsolat létrehozása
include("connection.php");
include("functions.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Az űrlapról érkező adatok fogadása
    $vonatszam = $_POST['vonatszam'];
    $honnan = $_POST['honnan'];
    $hova = $_POST['hova'];
    $indulasiIdo = DTLToStr($_POST['indulasi_ido']);
    $menetido = DTLToStr($_POST['menetido']);
    $vonattipus = $_POST['vonattipus'];

    // Hibakezelés tömb inicializálása
    $problems = array();

    // Ellenőrizzük az adatok helyességét és hiányosságait
    if (empty($vonatszam) || !is_numeric($vonatszam)) {
        $problems['vonatszam'] = 'A vonatszámot kötelező megadni és csak szám lehet!';
    }

    // Check if the record already exists in the database
    $query = "SELECT COUNT(*) FROM Jarat WHERE Vonatszam = :vonatszam";
    $stmt = oci_parse($con, $query);
    oci_bind_by_name($stmt, ":vonatszam", $vonatszam);
    oci_execute($stmt);
    $row = oci_fetch_array($stmt, OCI_ASSOC);
    if ($row['COUNT(*)'] > 0) {
        $problems['vonatszam'] = 'A menetrendben már szerepel ez a vonat! Próbáld azt módosítani!';
    }

    if (empty($honnan)) {
        $problems['honnan'] = 'A kiindulási helyet kötelező megadni!';
    }
    if (empty($hova)) {
        $problems['hova'] = 'A célállomást kötelező megadni!';
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

    if (empty($indulasiIdo)) {
        $problems['indulasi_ido'] = 'Az indulási időt kötelező megadni!';
    }
    if (empty($menetido)) {
        $problems['menetido'] = 'A menetidőt kötelező megadni!';
    }
    if (empty($vonattipus)) {
        $problems['vonattipus'] = 'A vonattípust kötelező megadni!';
    }

    // Ha nincsenek hibák, akkor hajtsuk végre a beszúrást
    if (count($problems) == 0) {
        // Prepare the insert statement
        $query = "INSERT INTO Jarat (Vonatszam, Honnan, Hova, Indulasi_ido, Menetido, Vonattipus)
                  VALUES (:vonatszam, :honnan, :hova, TO_TIMESTAMP(:indulasi_ido, 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP(:menetido, 'YYYY-MM-DD HH24:MI:SS'), :vonattipus)";

        $stmt = oci_parse($con, $query);
        oci_bind_by_name($stmt, ":vonatszam", $vonatszam);
        oci_bind_by_name($stmt, ":honnan", $honnan);
        oci_bind_by_name($stmt, ":hova", $hova);
        oci_bind_by_name($stmt, ":indulasi_ido", $indulasiIdo);
        oci_bind_by_name($stmt, ":menetido", $menetido);
        oci_bind_by_name($stmt, ":vonattipus", $vonattipus);
        $success = oci_execute($stmt);

        // Ellenőrizzük, hogy sikeres volt-e a beszúrás
        if ($success) {
            // Sikeres beszúrás esetén átirányítás
            $problems['success'] = 'Az adatok beszúrása sikeres!';
            header("Location: ../view/menetrendsearch.php");
            die;
        } else {
            // Hibás végrehajtás esetén hibaüzenet beállítása
            $problems['deleted'] = 'Az adatok beszúrása nem sikerült!';
        }
    }

    // Hibák üzenetének mentése a session-be
    $_SESSION["message"] = $problems;

    header('Location: ../view/menetrendsearch.php');
    die;
} else {
    // Ha nem POST kérés érkezett, az adatbázis kapcsolat bezárása
    oci_close($con);
}
?>
