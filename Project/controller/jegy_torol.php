<?php
    if(!isset($_SESSION)){session_start();}
    include("connection.php");
    
    if(isset($_SESSION["user_name"])){
        $torlendo = $_POST["tipus"];
        echo $torlendo;
        
        $query = "delete from vasarol where id='$torlendo'";
        // Oracle adatbázis kapcsolat létrehozása
       
        $stid = oci_parse($con, $query);
        oci_execute($stid);
        oci_commit($con);
        oci_free_statement($stid);
        oci_close($con);
        
        header('location: ../view/myprofile.php');
    }
    else{
        header('location: index.php');
        die;
    }
?>