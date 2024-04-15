<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
	
		$user_name = $_POST['user-name'];
		$pwd = $_POST['pwd'];
		
		$problems = array();
		if(empty($user_name) or $user_name==0 or is_numeric($user_name)){
			// collect problem
			$problems['user_name'] = 'Kötelező megadni';
		}
		if(empty($pwd) or $pwd==0){
			$problems['pwd'] = 'Kötelező megadni';
		}
		
		if(count($problems)==0){
			
			$query = "SELECT * from fiokok where user_name = ? limit 1";
			//$query_result = mysqli_query($con, $query);
			
			$stmt=mysqli_prepare($con, $query);
			mysqli_stmt_bind_param($stmt, "s", $user_name);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			mysqli_stmt_bind_result($stmt, $id, $user_name, $pwd_db);
			if($stmt && mysqli_stmt_num_rows($stmt) > 0){
				$user_data = mysqli_stmt_fetch($stmt);
				
				if(password_verify($pwd, $pwd_db)){
					$_SESSION["id"]=$id;
					//$_SESSION["user_name"] = $user_data["user_name"];
					$_SESSION["user_name"] = $user_name;
					$_SESSION["pwd"]=$pwd;
					$_SESSION["akt_csaladnev"]="";
					header("Location: myprofile.php");
					mysqli_close($con);
					die;
				}
				else{
					$problems['pwd'] = 'Rossz jelszó!';
					$_SESSION["message"] = $problems;
					header('location: login_page.php');
					mysqli_close($con);
					die;
				}
			}
			else{
				$problems['user_name'] = 'Ilyen felhasználó nem található.';
				$_SESSION["message"] = $problems;
				header('location: login_page.php');
				mysqli_close($con);
				die;
			}
		}
		else{
			$_SESSION["message"] = $problems;
			header('location: login_page.php');
			mysqli_close($con);
			die;
		}
	}
	else{
		mysqli_close($con);
	}
?>