<?php
    // Adatbázis kapcsolat betöltése
    include 'connection.php';

    // Adatok összegyűjtése
    $type = $_POST['type'];
    $condition = $_POST['condition'];


    $ar = ($type == 'Teljesarú') ? 1000 : 500; 
    $idotartam = 30; 

    if ($type == 'Kedvezményes' || $type == 'Teljesarú') {
        // SQL parancs előkészítése
        $stid = oci_parse($conn, 'INSERT INTO Jegy (Tipus, Ar, Feltetel, Idotartam) VALUES (:type, :ar, :condition, :idotartam)');

        // Paraméterek hozzáadása
        oci_bind_by_name($stid, ':type', $type);
        oci_bind_by_name($stid, ':ar', $ar);
        oci_bind_by_name($stid, ':condition', $condition);
        oci_bind_by_name($stid, ':idotartam', $idotartam);

        // SQL parancs végrehajtása
        oci_execute($stid);
    }

    // Kapcsolat bezárása
    oci_close($conn);
?>