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
			$problems['pwd'] = 'Az új jelszónak 6 karakter hosszúnak kell lennie.';
		}
        if($pwd==$new_pwd){
            $problems['pwd'] = 'A két jelszó nem egyezhet meg!';
        }
		if($new_pwd != $new_pwd_2){
			$problems['pwd_2'] = 'A két jelszó nem egyezik meg';
		}
        if(count($problems)==0){
			// password hash
			$new_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
			
            $query = "UPDATE fiokok SET pwd=? where id=?";
			$stmt=mysqli_prepare($con, $query);
			mysqli_stmt_bind_param($stmt, "si", $new_pwd, $_SESSION["id"]);
			$siker=mysqli_stmt_execute($stmt); 
			//mysqli_query($con, $query);
			if ($siker) {
				$_SESSION["user_name"] = $user_name;
				header("Location: ../view/myprofile.php");
			}
			mysqli_stmt_close($con);
			die;
		}
		else{
			$_SESSION["message"] = $problems;
			header('location: ../view/refresh_pwd_page.php');
			mysqli_stmt_close($con);
			die;
		}
	}
	else{
		mysqli_close($con);
	}
?>