<?php
    if(!isset($_SESSION)){session_start();}
    include("connection.php");
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $newsid=$_SESSION["newsid"];

        $hir_id = $_POST['hir-id'];
      
        $cim = $_POST['cim'];
        $szoveg = $_POST['szoveg'];
     
     

        $problems = array();

        if(strlen($cim)==0){
			$problems['cim'] = 'A címet kötelező megadni!';
            var_dump($problems['cim']);
		}
        if(strlen($szoveg)==0){
            $problems['szoveg'] = 'A szöveget kötelező megadni!';
            var_dump($problems['szoveg']);
        }

     
      
        $query = "select * from hir where hirid = :hir_id";
        $stid = oci_parse($con, $query);
        oci_bind_by_name($stid, ':hir_id', $hir_id);
        oci_execute($stid);
        if(oci_fetch($stid)){
            $problems['hir_id'] = 'Ez a felhasználónév foglalt.';
        }

        if(count($problems)==0){
            
            
    

            if (!empty($cim)) {
                $query = "UPDATE hir SET cim=:cim where hirid=:newsid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':cim', $cim);
                oci_bind_by_name($stid, ':newsid', $_SESSION["newsid"]);
                oci_execute($stid);
               
            }

            if (!empty($szoveg)) {
                $query = "UPDATE hir SET szoveg=:szoveg where hirid=:newsid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':szoveg', $szoveg);
                oci_bind_by_name($stid, ':newsid', $_SESSION["newsid"]);
                oci_execute($stid);
                
            }

           #dátumot átállítjuk mára, hisz most frissítettük
          
           $currentDate = new DateTime();
           

            $query = "UPDATE hir SET datum=TO_DATE(:selected_date, 'YYYY-MM-DD') where hirid=:newsid";
            $stid = oci_parse($con, $query);
            oci_bind_by_name($stid, ':selected_date', $currentDate->format('Y-m-d'));
            oci_bind_by_name($stid, ':newsid', $_SESSION["newsid"]);
            oci_execute($stid);


            if ($_SESSION["admin"]==1) {
                header("Location: ../view/newssearch.php");
            }
            else{
                header("Location: ../view/myprofile.php");

            }
            
            oci_close($con);
            die;
        }
        else{
            $_SESSION["message"] = $problems;
            while ($e = current($problems)) {
                $key = key($problems);
                $_SESSION["message"][$key] = $e;
                next($problems);
                echo $key . " " . $e . "<br>";
            }
            header('location: ../view/newssearch.php');
            oci_close($con);
            die;
        }
    }
    else{
        header("Location: ../view/newssearch.php");
        oci_close($con);
    }
?>
