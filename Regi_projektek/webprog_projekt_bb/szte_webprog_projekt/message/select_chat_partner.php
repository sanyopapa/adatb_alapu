<?php
	if(!isset($_SESSION)){session_start();}
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		unset($_SESSION["chat-partner"]);
		
		include("../connection.php");
		$partner = $_POST['chat-partner'];
		
		if($partner == $_SESSION["user_name"]){
			$_SESSION["message"] = -1;
		}
		else {
			$query = "select * from users where user_name = '$partner' limit 1";
			$query_result = mysqli_query($con, $query);
			
			// check for error
			if($query_result && mysqli_num_rows($query_result) == 0){
				$_SESSION["message"] = -1;
			}
			else {
				$_SESSION["chat-partner"] = $partner;
			}
		}
		
		header('location: message_page.php');
		mysqli_close($con);   // close the database connection!
		die;
	}
?>