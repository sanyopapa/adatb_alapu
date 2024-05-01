<?php
if (!isset($_SESSION)) {
    session_start();
}
include("connection.php");

function DTLToStr($converted_string) {
    // Átalakítjuk az adott formátumra
    $datetime = str_replace("T", " ", $converted_string) . ":00";

    // Ellenőrizzük, hogy sikerült-e a konverzió
    if ($datetime === false) {
        return ""; // Sikertelen konverzió esetén üres stringet adjunk vissza
    }

    // Eredeti string formátumra alakítása
    return $datetime;
 
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $allomasnev = $_POST['allomasnev'];
    $vonatszam = $_POST['vonatszam'];
    $erkezes = DTLToStr($_POST['erkezes']);
    $indulas = DTLToStr($_POST['indulas']);
 

    

    $problems = array();

    if (empty($allomasnev)) {
        $problems['allomasnev'] = 'Az állomás nevét kötelező megadni!';
    }
    if (empty($vonatszam) || !is_numeric($vonatszam)) {
        $problems['vonatszam'] = 'A vonatszámot meg kell adni!';
    }
    if (empty($erkezes)) {
        $problems['erkezes'] = 'Az érkezési időt meg kell adni!';
    }   
    if (empty($indulas)) {
        $problems['indulas'] = 'Az indulási időt meg kell adni!';
    }

    if (count($problems) == 0) {
        // Ellenőrzés, hogy az állomásnév és vonatszám már létezik-e
        $query = "SELECT * FROM kozlekedik WHERE allomasnev = :allomasnev AND vonatszam = :vonatszam";
        $stid = oci_parse($con, $query);
        oci_bind_by_name($stid, ':allomasnev', $allomasnev);
        oci_bind_by_name($stid, ':vonatszam', $vonatszam);
        oci_execute($stid);
        if (oci_fetch($stid)) {
            // Ha létezik, akkor frissítjük az adatokat
            $query = "UPDATE kozlekedik SET erkezes = TO_TIMESTAMP(:erkezes, 'YYYY-MM-DD HH24:MI:SS'), indulas = TO_TIMESTAMP(:indulas, 'YYYY-MM-DD HH24:MI:SS') WHERE allomasnev = :allomasnev AND vonatszam = :vonatszam";
            $stid = oci_parse($con, $query);
            oci_bind_by_name($stid, ':erkezes', $erkezes);
            oci_bind_by_name($stid, ':indulas', $indulas);
            oci_bind_by_name($stid, ':allomasnev', $allomasnev);
            oci_bind_by_name($stid, ':vonatszam', $vonatszam);
            oci_execute($stid);

            // Sikeres frissítés esetén átirányítás
            $problems['success'] = "Sikeres módosítás!";
            $_SESSION["message"] = $problems;
            header("Location: ../view/kozlekediksearch.php");
            oci_close($con);
            die;
        } else {
            $problems['vonatszam'] = 'Ez az állomás és vonatszám kombináció még nem létezik, kérlek próbálkozz új adat hozzáadásával.';
        }
    }

    // Hibák esetén visszairányítás a felhasználóhoz
    $_SESSION["message"] = $problems;

    header('location: ../view/kozlekediksearch.php');
    oci_close($con);
    die;
} else {
    // Ha nem POST kérés érkezett, visszairányítás
    header("Location: ../view/kozlekediksearch.php");
    oci_close($con);
}
?>
