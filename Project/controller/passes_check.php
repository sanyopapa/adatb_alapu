<?php
	if(!isset($_SESSION)){session_start();}
	include("../controller/connection.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$passes_type = $_POST['passes-type'];
		$email = $_POST['email'];

		$problems = array();

		if(empty($email) or $email==0 or is_numeric($email)){
			$problems['email'] = 'Felhasználó nevet kötelező megadni!';
		}


		$query = "SELECT * FROM Felhasznalo WHERE email = '$email'";
		$query_result = oci_parse($con, $query);
	
		$exc=oci_execute($query_result);
		
		
		if(($exc && oci_fetch($query_result))){
			
		} else{
			$problems['email'] = 'Még nincs ilyen Email-cím regisztrálva!';
		
		}


		if (count($problems)>0) {
            foreach ($problems as $error) {
                echo "<div'>$error</div>";
            }
		}


		if(count($problems)==0){

			// Insert data into Vasarlo table
			$insertQuery = "INSERT INTO Vasarol (Email, Tipus) VALUES (:email, :passes_type)";
			$stmt = oci_parse($con, $insertQuery);
			oci_bind_by_name($stmt, ":email", $email);
			oci_bind_by_name($stmt, ":passes_type", $passes_type);
			$sikeres=oci_execute($stmt);	

			if($sikeres){
				// Data inserted successfully
				$problems['success']="Sikeres bérletvétel!";
				$_SESSION["message"] = $problems;
				header('location: ../view/passes.php');
				die;

			} else {
				// Error occurred while inserting data
				echo "Error: " . oci_error($con);
			}
			oci_free_statement($stmt);

		
		}else
		{
			$_SESSION["message"] = $problems;
			header('location: ../view/passes.php');
			oci_close($con);
			die;
		}
	}
	else{
		
		oci_close($con);
		die;
	}

?>