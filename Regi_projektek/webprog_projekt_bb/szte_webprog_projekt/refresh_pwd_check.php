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
			
            $query = "UPDATE users SET pwd='$new_pwd' where id='" . $_SESSION["id"] . "'";
			mysqli_query($con, $query);
			$_SESSION["user_name"] = $user_name;
			header("Location: myprofile.php");
			mysqli_close($con);
			die;
		}
		else{
			$_SESSION["message"] = $problems;
			header('location: refresh_page.php');
			mysqli_close($con);
			die;
		}
	}
	else{
		mysqli_close($con);
	}
?>