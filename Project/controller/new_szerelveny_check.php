<?php
if (!isset($_SESSION)) {
    session_start();
}

// Adatbázis kapcsolat létrehozása
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Az űrlapról érkező adatok fogadása
    $szNev = $_POST['sznev'];
    $gyartasiEv = $_POST['gyartasi_ev'];
    $meghajtas = $_POST['meghajtas'];
    $kapacitas = $_POST['kapacitas'];
    $kerekparhelyekSzama = $_POST['kerekparhelyek_szama'];
    $osztaly = $_POST['osztaly'];

    // Hibakezelés tömb inicializálása
    $problems = array();

    // Ellenőrizzük az adatok helyességét és hiányosságait
    if (empty($szNev)) {
        $problems['sznev'] = 'A szerelvény nevét kötelező megadni!';
    }
    // Ellenőrizzük, hogy szerepel-e már a szerelvény táblában
    $query = "SELECT COUNT(*) FROM Szerelveny WHERE SzNev = :szNev";
    $stmt = oci_parse($con, $query);
    oci_bind_by_name($stmt, ":szNev", $szNev);
    oci_execute($stmt);
    $row = oci_fetch_array($stmt, OCI_ASSOC);
    $count = $row['COUNT(*)'];

    if ($count > 0) {
        $problems['sznev'] = 'A szerelvény már szerepel a táblában!';
    }
    if (empty($gyartasiEv) || !is_numeric($gyartasiEv)) {
        $problems['gyartasi_ev'] = 'A gyártási év megadása kötelező és csak szám lehet!';
    }
    
    if (isset($kapacitas) && $kapacitas!="" && !is_numeric($kapacitas)) {
        $problems['kapacitas'] = 'A kapacitás csak szám lehet!';
    }
    if (isset($kerekparhelyek_szama) && $kapacitas!="" && !is_numeric($kerekparhelyek_szama)) {
        $problems['kerekparhelyek_szama'] = 'A kerékpárhelyek száma csak szám lehet!';
    }
    if (isset($osztaly) && $osztaly!="" && !is_numeric($osztaly) && $osztaly !=null) {
        $problems['osztaly'] = 'Az osztály csak szám lehet!';
    }

    // Ha nincsenek hibák, akkor hajtsuk végre a beszúrást
    if (count($problems) == 0) {
        // Prepare the insert statement
        $query = "INSERT INTO Szerelveny (SzNev, Gyartasi_ev, Meghajtas, Kapacitas, Kerekparhelyek_szama, Osztaly)
                  VALUES (:szNev, :gyartasiEv, :meghajtas, :kapacitas, :kerekparhelyekSzama, :osztaly)";

        $stmt = oci_parse($con, $query);
        oci_bind_by_name($stmt, ":szNev", $szNev);
        oci_bind_by_name($stmt, ":gyartasiEv", $gyartasiEv);
        oci_bind_by_name($stmt, ":meghajtas", $meghajtas);
        oci_bind_by_name($stmt, ":kapacitas", $kapacitas);
        oci_bind_by_name($stmt, ":kerekparhelyekSzama", $kerekparhelyekSzama);
        oci_bind_by_name($stmt, ":osztaly", $osztaly);
        $success = oci_execute($stmt);

        // Ellenőrizzük, hogy sikeres volt-e a beszúrás
        if ($success) {
            // Sikeres beszúrás esetén átirányítás
            header("Location: ../view/szerelvenysearch.php");
            die;
        } else {
            // Hibás végrehajtás esetén hibaüzenet beállítása
            $problems['insert'] = 'Az adatok beszúrása nem sikerült!';
        }
    }

    // Hibák üzenetének mentése a session-be
    $_SESSION["message"] = $problems;

    header('Location: ../view/szerelvenysearch.php');
    die;
} else {
    // Ha nem POST kérés érkezett, az adatbázis kapcsolat bezárása
    oci_close($con);
}
?>
