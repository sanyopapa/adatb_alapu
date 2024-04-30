<?php
    if(!isset($_SESSION)){session_start();}
    include("connection.php");
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $tipus = $_POST['tipus'];
      
        $ar = $_POST['ar'];
        $feltetel = $_POST['feltetel'];
        $idotartam = $_POST['idotartam'];

        $problems = array();

        if(strlen($tipus) == 0){
			$problems['tipus'] = 'A jegytípust kötelező megadni!';
		}
        if(empty($ar) || !is_numeric($ar)){
            $problems['ar'] = 'Az árat meg kell adni!';
        }
        if(strlen($feltetel) == 0){
            $problems['feltetel'] = 'A feltételt kötelező megadni!';
        }
        if(empty($idotartam) || !is_numeric($idotartam)){
            $problems['idotartam'] = 'Az időtartamot kötelező  megadni!';
        }

        if(count($problems) == 0){
            // Ellenőrzés, hogy a jegytípus már létezik-e
            $query = "SELECT * FROM jegy WHERE tipus = :tipus";
            $stid = oci_parse($con, $query);
            oci_bind_by_name($stid, ':tipus', $tipus);
            oci_execute($stid);
            if(oci_fetch($stid)){
                // Ha létezik, akkor frissítjük az adatokat
                $query = "UPDATE jegy SET ar = :ar, feltetel = :feltetel, idotartam = :idotartam WHERE tipus = :tipus";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':ar', $ar);
                oci_bind_by_name($stid, ':feltetel', $feltetel);
                oci_bind_by_name($stid, ':idotartam', $idotartam);
                oci_bind_by_name($stid, ':tipus', $tipus);
                oci_execute($stid);

                // Sikeres frissítés esetén átirányítás
                $problems['success']="Sikeres módosítás!";
				$_SESSION["message"] = $problems;
                header("Location: ../view/ticketsearch.php");
                oci_close($con);
                die;
            } else {
                $problems['tipus'] = 'Ez a jegytípus még nem létezik, kérlek új jegy létrehozásával probálkozz.';
            }
        }
        
        // Hibák esetén visszairányítás a felhasználóhoz
        $_SESSION["message"] = $problems;
        
        header('location: ../view/ticketsearch.php');
        oci_close($con);
        die;
        
    } else {
        // Ha nem POST kérés érkezett, visszairányítás
        header("Location: ../view/ticketsearch.php");
        oci_close($con);
    }
?>
