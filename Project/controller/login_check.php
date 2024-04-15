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

			$query = "SELECT * from felhasznalo where email = :user_name";
			$stmt = oci_parse($con, $query);
			oci_bind_by_name($stmt, ":user_name", $user_name);
			oci_execute($stmt);

			$row = oci_fetch_assoc($stmt);
			if($row){
				$pwd_db = $row['JELSZO'];

				if(password_verify($pwd, $pwd_db)){
					$_SESSION["user_name"] = $row['FELHASZNALONEV'];
					$_SESSION["pwd"] = $pwd;
					$_SESSION["admin"] = $row['ADMIN'];
					header("Location: ../view/myprofile.php");
					oci_close($con);
					die;
				}
				else{
					$problems['pwd'] = 'Rossz jelszó!';
					$_SESSION["message"] = $problems;
					header('location: ../view/login_page.php');
					oci_close($con);
					die;
				}
			}
			else{
				$problems['user_name'] = 'Ilyen felhasználó nem található.';
				$_SESSION["message"] = $problems;
				header('location: ../view/login_page.php');
				oci_close($con);
				die;
			}
		}
		else{
			$_SESSION["message"] = $problems;
			header('location: ../view/login_page.php');
			oci_close($con);
			die;
		}
	}
	else{
		oci_close($con);
	}
?>
