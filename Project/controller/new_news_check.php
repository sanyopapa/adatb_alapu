<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$cim = $_POST['cim'];
        $szoveg = $_POST['szoveg'];
		var_dump($cim);
        var_dump($szoveg);
		$problems = array();
		
		
		if(strlen($cim)==0){
			$problems['cim'] = 'A címet kötelező megadni!';
            var_dump($problems['cim']);
		}
        if(strlen($szoveg)==0){
            $problems['szoveg'] = 'A szöveget kötelező megadni!';
            var_dump($problems['szoveg']);
        }
		

		//$query = "select * from fiokok where email = '$email' and rownum <= 1";
		if(count($problems)==0){
        
            var_dump("itt vagyok");
     
            $qry = "SELECT max(Hirid)+1 from Hir";
            $stm = oci_parse($con, $qry);
            oci_execute($stm);
            $row=oci_fetch_assoc($stm);
            $hirid=$row['MAX(HIRID)+1'];
            
          
            $currentDate = new DateTime();
            var_dump($currentDate->format('Y-m-d'));
			$query="INSERT into Hir (Hirid, cim, szoveg, datum)
            values ((:hirid), :cim, :szoveg, TO_DATE(:selected_date, 'YYYY-MM-DD'))";
			$stmt=oci_parse($con, $query);
            var_dump($stmt);
            oci_bind_by_name($stmt, ":hirid", $hirid);
			oci_bind_by_name($stmt, ":cim", $cim);
			oci_bind_by_name($stmt, ":szoveg", $szoveg);
            oci_bind_by_name($stmt, ':selected_date', $currentDate->format('Y-m-d'));
			$sikeres=oci_execute($stmt);	
			//$query = "insert into fiokok (user_name,pwd) values('$user_name', '$pwd')";
			//mysqli_query($con, $query);
			if ($sikeres) {
                //kell?????????
                //$problems['success'] = 'Sikeres hozzáadás!';
                //$_SESSION["message"] = $problems;

				
				header("Location: ../view/news.php");
				oci_free_statement($stmt);
				die;
			}
            oci_free_statement($stmt);
		}
		else
		{
			$_SESSION["message"] = $problems;
		    header('location: ../view/admin_news_edit.php');
		
			die;
		}
	}
	else{
		oci_close($con);
	}
?>