<?php
if (!isset($_SESSION)) {
    session_start();
}

// Adatbázis kapcsolat létrehozása
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Az űrlapról érkező adatok fogadása
    $nev = $_POST['nev'];
    $varos = $_POST['varos'];

    // Hibakezelés tömb inicializálása
    $problems = array();

    // Ellenőrizzük az adatok helyességét és hiányosságait
    if (empty($nev)) {
        $problems['nev'] = 'Az állomás nevét kötelező megadni!';
    }
    if (empty($varos)) {
        $problems['varos'] = 'A várost kötelező megadni!';
    }

    // Ha nincsenek hibák, akkor hajtsuk végre a beszúrást
    if (count($problems) == 0) {
        // Prepare the insert statement
        $query = "INSERT INTO Allomas (Nev, Varos)
                  VALUES (:nev, :varos)";

        $stmt = oci_parse($con, $query);
        oci_bind_by_name($stmt, ":nev", $nev);
        oci_bind_by_name($stmt, ":varos", $varos);
        $success = oci_execute($stmt);

        // Ellenőrizzük, hogy sikeres volt-e a beszúrás
        if ($success) {
            // Sikeres beszúrás esetén átirányítás
            header("Location: ../view/allomas_view.php");
            die;
        } else {
            // Hibás végrehajtás esetén hibaüzenet beállítása
            $problems['insert'] = 'Az adatok beszúrása nem sikerült!';
        }
    }

    // Hibák üzenetének mentése a session-be
    $_SESSION["message"] = $problems;

    // Átirányítás a ticketsearch.php oldalra
    header('Location: ../view/allomas_search.php');
    die;
} else {
    // Ha nem POST kérés érkezett, az adatbázis kapcsolat bezárása
    oci_close($con);
}
?>
