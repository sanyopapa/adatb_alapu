<?php
if (!isset($_SESSION)) {
    session_start();
}

// Adatbázis kapcsolat létrehozása
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Az űrlapról érkező adatok fogadása
    $allomasnev = $_POST['allomasnev'];
    $vonatszam = $_POST['vonatszam'];
    $erkezes = DTLToStr($_POST['erkezes']);
    $indulas = DTLToStr($_POST['indulas']);

    // Hibakezelés tömb inicializálása
    $problems = array();

    // Ellenőrizzük az adatok helyességét és hiányosságait
    if (empty($allomasnev)) {
        $problems['allomasnev'] = 'Az állomás nevét kötelező megadni!';
    }
    if (empty($vonatszam) || !is_numeric($vonatszam)) {
        $problems['vonatszam'] = 'A vonatszámot kötelező megadni és csak szám lehet!';
    }
    if (empty($erkezes)) {
        $problems['erkezes'] = 'Az érkezési időt kötelező megadni!';
    }
    if (empty($indulas)) {
        $problems['indulas'] = 'Az indulási időt kötelező megadni!';
    }

    // Ha nincsenek hibák, akkor hajtsuk végre a beszúrást
    if (count($problems) == 0) {
        // Prepare the insert statement
        $query = "INSERT INTO Kozlekedik (Allomasnev, Vonatszam, Erkezes, Indulas)
                  VALUES (:allomasnev, :vonatszam, TO_TIMESTAMP(:erkezes, 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP(:indulas, 'YYYY-MM-DD HH24:MI:SS'))";

        $stmt = oci_parse($con, $query);
        oci_bind_by_name($stmt, ":allomasnev", $allomasnev);
        oci_bind_by_name($stmt, ":vonatszam", $vonatszam);
        oci_bind_by_name($stmt, ":erkezes", $erkezes);
        oci_bind_by_name($stmt, ":indulas", $indulas);
        $success = oci_execute($stmt);

        // Ellenőrizzük, hogy sikeres volt-e a beszúrás
        if ($success) {
            // Sikeres beszúrás esetén átirányítás
            $problems['success']="Sikeres beszúrás!";
            header("Location: ../view/kozlekediksearch.php");
            die;
        } else {
            // Hibás végrehajtás esetén hibaüzenet beállítása
            $problems['deleted'] = 'Az adatok beszúrása nem sikerült! <br> (Biztos létező vonat/számot adtál meg?)';
        }
    }

    // Hibák üzenetének mentése a session-be
    $_SESSION["message"] = $problems;

    header('Location: ../view/kozlekediksearch.php');
    die;
} else {
    // Ha nem POST kérés érkezett, az adatbázis kapcsolat bezárása
    oci_close($con);
}
?>
