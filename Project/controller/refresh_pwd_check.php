<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		// There was a POST
		$pwd = $_POST['pwd'];
		$new_pwd = $_POST['new_pwd'];
		$new_pwd_2 = $_POST['new_pwd_2'];
		
		// Check if the data is valid
		$problems = array();
		if(strlen($new_pwd)<6){
			$problems['pwd_2'] = 'Az új jelszónak 6 karakter hosszúnak kell lennie.';
		}
		if($pwd==$new_pwd){
			$problems['pwd'] = 'A két jelszó nem egyezhet meg!';
		}
		if($new_pwd != $new_pwd_2){
			$problems['pwd_2'] = 'A két jelszó nem egyezik meg';
		}
		
		// Check if pwd matches the SESSION password
		if(password_verify($pwd,$_SESSION['user_password'])){
			$problems['pwd'] = 'A régi jelszó nem egyezik a jelenlegi jelszóval!';
		}
		
		if(count($problems)==0){
			// password hash
			$new_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
			
			$query = "UPDATE Felhasznalo SET jelszo=:new_pwd where email=:id";
			$stmt = oci_parse($con, $query);
			oci_bind_by_name($stmt, ":new_pwd", $new_pwd);
			oci_bind_by_name($stmt, ":id", $_SESSION["user_name"]);
			$siker = oci_execute($stmt);
			
			if ($siker) {
				$_SESSION["user_name"] = $user_name;
				header("Location: ../view/myprofile.php");
			}
			oci_free_statement($stmt);
			die;
		}
		else{
			$_SESSION["message"] = $problems;
			header('location: ../view/refresh_pwd_page.php');
			oci_close($con);
			die;
		}
	}
	else{
		oci_close($con);
	}
?>