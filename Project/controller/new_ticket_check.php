<?php
    if(!isset($_SESSION)){session_start();}
    include("connection.php");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $tipus = $_POST['tipus'];
        $ar = $_POST['ar'];
        $feltetel = $_POST['feltetel'];
        $idotartam = $_POST['idotartam'];
        
        $problems = array();
        
        if(strlen($tipus)==0){
            $problems['tipus'] = 'A típust kötelező megadni!';
        }
        if($ar <= 0){
            $problems['ar'] = 'Az ár értéke nem lehet negatív vagy nulla!';
        }
        if(strlen($feltetel)==0){
            $problems['feltetel'] = 'A feltételt kötelező megadni!';
        }
        if($idotartam <= 0){
            $problems['idotartam'] = 'Az időtartam értéke nem lehet negatív vagy nulla!';
        }
        if(!is_numeric($ar)){
            $problems['ar'] = 'Az ár csak szám lehet!';
        }
        if(!is_numeric($idotartam)){
            $problems['idotartam'] = 'Az időtartam csak szám lehet!';
        }
        
        $query = "SELECT COUNT(*) FROM Jegy WHERE Tipus = :tipus";
        $stmt = oci_parse($con, $query);
        oci_bind_by_name($stmt, ":tipus", $tipus);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        if ($row['COUNT(*)'] > 0) {
            $problems['tipus'] = 'A megadott típus már létezik a rendszerben!';
        }
        oci_free_statement($stmt);

        if(count($problems)==0){
            $query = "SELECT MAX(Tipus) FROM Jegy";
            $stmt = oci_parse($con, $query);
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            
            $query = "INSERT INTO Jegy (Tipus, Ar, Feltetel, Idotartam)
                      VALUES (:tipus, :ar, :feltetel, :idotartam)";
            $stmt = oci_parse($con, $query);
            oci_bind_by_name($stmt, ":tipus", $tipus);
            oci_bind_by_name($stmt, ":ar", $ar);
            oci_bind_by_name($stmt, ":feltetel", $feltetel);
            oci_bind_by_name($stmt, ":idotartam", $idotartam);
            $success = oci_execute($stmt);    
            oci_free_statement($stmt);

            if ($success) {
                header("Location: ../view/ticket_view.php");
                die;
            }
        } else {
            $_SESSION["message"] = $problems;
            header('location: ../view/ticketsearch.php');
            die;
        }
    } else {
        oci_close($con);
    }
?>
