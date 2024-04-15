<?php
    // Adatbázis kapcsolat betöltése
    include 'connection.php';

    // Adatok összegyűjtése
    $name = $_POST['name'];
    $condition = $_POST['condition'];
    $type = $_POST['type'];
    $varmegye = $_POST['varmegye'];

   
    $ar = 1000; 
    $idotartam = 30; 

    // SQL parancs előkészítése
    $stid = oci_parse($conn, 'INSERT INTO Jegy (Tipus, Ar, Feltetel, Idotartam) VALUES (:type, :ar, :condition, :idotartam)');

    // Paraméterek hozzáadása
    oci_bind_by_name($stid, ':type', $type);
    oci_bind_by_name($stid, ':ar', $ar);
    oci_bind_by_name($stid, ':condition', $condition);
    oci_bind_by_name($stid, ':idotartam', $idotartam);

    // SQL parancs végrehajtása
    oci_execute($stid);

    // Kapcsolat bezárása
    oci_close($conn);
?>