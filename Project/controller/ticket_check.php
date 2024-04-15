<?php
	if(!isset($_SESSION)){session_start();}
	include("../controller/connection.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$ticket_type = $_POST['ticket-type'];
		$email = $_SESSION['user_name'];

		$problems = array();

		$date = $_POST['kezdet'];

		// Convert the date string to a DateTime object
		$selectedDate = DateTime::createFromFormat('Y-m-d', $date);

		// Get the current date
		$currentDate = new DateTime();
		if ($selectedDate==null) {
			$selectedDate = $currentDate;
		}
		// Compare the selected date with the current date
		if ($selectedDate < $currentDate) {
			$problems['date'] = "A kiválasztott dátum régebbi, mint a mai nap!";
		}

		if(count($problems)==0){
			// Count the number of rows in the Vasarol table
			$countQuery = "SELECT COUNT(*) FROM Vasarol";
			$countStmt = oci_parse($con, $countQuery);
			oci_execute($countStmt);
			$row = oci_fetch_array($countStmt);
			$rowCount = $row[0];

			// Use the rowCount variable as needed
			// Insert data into Vasarol table
			$insertQuery = "INSERT INTO Vasarol (id, Email, Tipus, Kezdet) VALUES (:id, :email, :ticket_type, TO_DATE(:selected_date, 'YYYY-MM-DD'))";
			$stmt = oci_parse($con, $insertQuery);
			oci_bind_by_name($stmt, ":id", $rowCount);
			oci_bind_by_name($stmt, ":email", $email);
			oci_bind_by_name($stmt, ":ticket_type", $ticket_type);
			oci_bind_by_name($stmt, ":selected_date", $selectedDate->format('Y-m-d'));
			$sikeres = oci_execute($stmt);

			if($sikeres){
				// Data inserted successfully
				$problems['success']="Sikeres jegyvétel!";
				$_SESSION["message"] = $problems;
				header('location: ../view/ticket.php');
				die;

			} else {
				// Error occurred while inserting data
				echo "Error: " . oci_error($con);
			}
			oci_free_statement($stmt);

		
		}else
		{
			$_SESSION["message"] = $problems;
            while ($e = current($problems)) {
                $key = key($problems);
                $_SESSION["message"][$key] = $e;
                next($problems);
                echo $key . " " . $e . "<br>";
			oci_close($con);
			die;
		}
	}
	} else{
		
		oci_close($con);
		die;
	}

?>