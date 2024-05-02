<?php
if (!isset($_SESSION)) {
    session_start();
}

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sznev = $_POST['sznev'];
    $gyartasi_ev = $_POST['gyartasi_ev'];
    $meghajtas = $_POST['meghajtas'];
    $kapacitas = $_POST['kapacitas'];
    $kerekparhelyek_szama = $_POST['kerekparhelyek_szama'];
    $osztaly = $_POST['osztaly'];

    $problems = array();

    if (strlen($sznev) == 0) {
        $problems['sznev'] = 'A szerelvény nevét kötelező megadni!';
    }
    if (empty($gyartasi_ev) || !is_numeric($gyartasi_ev)) {
        $problems['gyartasi_ev'] = 'A gyártási évet meg kell adni számként!';
    }
    
    if (isset($kapacitas) && $kapacitas!="" && !is_numeric($kapacitas) && $kapacitas !=null) {
        $problems['kapacitas'] = 'A kapacitást számként kell megadni!';
    }
    if (isset($kerekparhelyek_szama) && $kapacitas!="" && !is_numeric($kerekparhelyek_szama) && $kerekparhelyek_szama !=null) {
        $problems['kerekparhelyek_szama'] = 'A kerékpárhelyek számát számként kell megadni!';
    }
    if (isset($osztaly) && $kapacitas!="" && !is_numeric($osztaly) && $osztaly !=null) {
        $problems['osztaly'] = 'Az osztályt számként kell megadni!';
    }

    if (count($problems) == 0) {
        // Ellenőrzés, hogy a szerelvény már létezik-e
        $query = "SELECT * FROM Szerelveny WHERE SzNev = :sznev";
        $stid = oci_parse($con, $query);
        oci_bind_by_name($stid, ':sznev', $sznev);
        oci_execute($stid);
        if (oci_fetch($stid)) {
            // Ha létezik, akkor frissítjük az adatokat
            $query = "UPDATE Szerelveny SET Gyartasi_ev = :gyartasi_ev, Meghajtas = :meghajtas, Kapacitas = :kapacitas, Kerekparhelyek_szama = :kerekparhelyek_szama, Osztaly = :osztaly WHERE SzNev = :sznev";
            $stid = oci_parse($con, $query);
            oci_bind_by_name($stid, ':gyartasi_ev', $gyartasi_ev);
            oci_bind_by_name($stid, ':meghajtas', $meghajtas);
            oci_bind_by_name($stid, ':kapacitas', $kapacitas);
            oci_bind_by_name($stid, ':kerekparhelyek_szama', $kerekparhelyek_szama);
            oci_bind_by_name($stid, ':osztaly', $osztaly);
            oci_bind_by_name($stid, ':sznev', $sznev);
            oci_execute($stid);

            // Sikeres frissítés esetén átirányítás
            $problems['success'] = "Sikeres módosítás!";
            $_SESSION["message"] = $problems;
            header("Location: ../view/szerelvenysearch.php");
            oci_close($con);
            die;
        } else {
            $problems['sznev'] = 'Ez a szerelvény még nem létezik, kérlek új szerelvény létrehozásával próbálkozz.';
        }
    }

    // Hibák esetén visszairányítás a felhasználóhoz
    $_SESSION["message"] = $problems;
    header('location: ../view/szerelvenysearch.php');
    oci_close($con);
    die;

} else {
    // Ha nem POST kérés érkezett, visszairányítás
    header("Location: ../view/szerelvenysearch.php");
    oci_close($con);
}
?>
