<?php
if (!isset($_SESSION)) {
    session_start();
}

// Adatbázis kapcsolat létrehozása
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Az űrlapról érkező adatok fogadása
    $szNev = $_POST['szNev'];
    $gyartasiEv = $_POST['gyartasiEv'];
    $meghajtas = $_POST['meghajtas'];
    $kapacitas = $_POST['kapacitas'];
    $kerekparhelyekSzama = $_POST['kerekparhelyekSzama'];
    $osztaly = $_POST['osztaly'];

    // Hibakezelés tömb inicializálása
    $problems = array();

    // Ellenőrizzük az adatok helyességét és hiányosságait
    if (empty($szNev)) {
        $problems['szNev'] = 'A szerelvény nevét kötelező megadni!';
    }
    if (empty($gyartasiEv) || !is_numeric($gyartasiEv)) {
        $problems['gyartasiEv'] = 'A gyártási év megadása kötelező és csak szám lehet!';
    }
    if (empty($meghajtas)) {
        $problems['meghajtas'] = 'A meghajtás típusát kötelező megadni!';
    }
    if (empty($kapacitas) || !is_numeric($kapacitas)) {
        $problems['kapacitas'] = 'A kapacitás megadása kötelező és csak szám lehet!';
    }
    if (empty($kerekparhelyekSzama) || !is_numeric($kerekparhelyekSzama)) {
        $problems['kerekparhelyekSzama'] = 'A kerékpárhelyek számának megadása kötelező és csak szám lehet!';
    }
    if (empty($osztaly) || !is_numeric($osztaly)) {
        $problems['osztaly'] = 'Az osztály megadása kötelező és csak szám lehet!';
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
            header("Location: ../view/ticket_view.php");
            die;
        } else {
            // Hibás végrehajtás esetén hibaüzenet beállítása
            $problems['insert'] = 'Az adatok beszúrása nem sikerült!';
        }
    }

    // Hibák üzenetének mentése a session-be
    $_SESSION["message"] = $problems;

    // Átirányítás a ticketsearch.php oldalra
    header('Location: ../view/ticketsearch.php');
    die;
} else {
    // Ha nem POST kérés érkezett, az adatbázis kapcsolat bezárása
    oci_close($con);
}
?>
