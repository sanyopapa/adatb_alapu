<?php
if (!isset($_SESSION)) {
    session_start();
}

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nev = $_POST['nev'];
    $varos = $_POST['varos'];

    $problems = array();

    if (strlen($nev) == 0) {
        $problems['nev'] = 'Az állomás nevét kötelező megadni!';
    }
    if (strlen($varos) == 0) {
        $problems['varos'] = 'Az állomás városát kötelező megadni!';
    }

    if (count($problems) == 0) {
        // Ellenőrzés, hogy az állomás név már létezik-e
        $query = "SELECT * FROM Allomas WHERE Nev = :nev";
        $stid = oci_parse($con, $query);
        oci_bind_by_name($stid, ':nev', $nev);
        oci_execute($stid);
        if (oci_fetch($stid)) {
            $problems['nev'] = 'Ilyen állomás már létezik a rendszerben!';
        } else {
            // Ha nem létezik, akkor beszúrjuk az adatokat
            $query = "INSERT INTO Allomas (Nev, Varos) VALUES (:nev, :varos)";
            $stid = oci_parse($con, $query);
            oci_bind_by_name($stid, ':nev', $nev);
            oci_bind_by_name($stid, ':varos', $varos);
            oci_execute($stid);

            // Sikeres beszúrás esetén átirányítás
            $problems['success'] = "Az állomás sikeresen hozzáadva!";
            $_SESSION["message"] = $problems;
            header("Location: ../view/allomassearch.php");
            oci_close($con);
            die;
        }
    }

    // Hibák esetén visszairányítás a felhasználóhoz
    $_SESSION["message"] = $problems;

    header('location: ../view/allomassearch.php');
    oci_close($con);
    die;
} else {
    // Ha nem POST kérés érkezett, visszairányítás
    header("Location: ../view/allomassearch.php");
    oci_close($con);
}
?>
