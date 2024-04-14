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
			
			$query = "select * from users where user_name = '$user_name' limit 1";
			$query_result = mysqli_query($con, $query);
			
			if($query_result && mysqli_num_rows($query_result) > 0){
				$user_data = mysqli_fetch_assoc($query_result);
				
				if(password_verify($pwd, $user_data["pwd"])){
					$_SESSION["id"]=$user_data["id"];
					$_SESSION["user_name"] = $user_data["user_name"];
					$_SESSION["pwd"]=$user_data["pwd"];
					$_SESSION["email"]=$user_data["email"];
					$_SESSION["birth"]=$user_data["birth"];
					$_SESSION["intro"]=$user_data["intro"];
					$_SESSION["admin"] =$user_data["admin"];
					$_SESSION["moderator"] =$user_data["moderator"];
					$_SESSION["sudo"] =$user_data["sudo"];
					$_SESSION["email_vis"]=$user_data["email_vis"];
					$_SESSION["birth_vis"]=$user_data["birth_vis"];
					$_SESSION["profpic_route"]=$user_data["profpic_route"];
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