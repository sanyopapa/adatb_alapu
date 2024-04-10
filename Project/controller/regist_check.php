<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$user_name = $_POST['user-name'];
		$pwd = $_POST['pwd'];
		$pwd_2 = $_POST['pwd-2'];
		
		$problems = array();
		
		if(empty($user_name) or $user_name==0 or is_numeric($user_name)){
			$problems['user_name'] = 'Felhasználó nevet kötelező megadni!';
		}
		if(is_numeric($user_name)){
			$problems['user_name'] = 'A felhasználó névnek tartalmaznia kell betűket!';
		}
		if(strlen($pwd)<6){
			$problems['pwd'] = 'A jelszó legalább 6 karaktert kell tartalmazzon!';
		}
		if($pwd != $pwd_2){
			$problems['pwd_2'] = 'A jelszavak nem egyeznek!';
		}
		$query = "select * from fiokok where Felhasznalonev = '$user_name' and rownum <= 1";
		$query_result = oci_parse($con, $query);
		oci_execute($query_result);
		if($query_result && oci_fetch($query_result)){
			$problems['user_name'] = 'Ez a felhasználónév foglalt.';
		}
		//$query = "select * from fiokok where email = '$email' and rownum <= 1";
		if(count($problems)==0){
			$pwd = password_hash($pwd, PASSWORD_DEFAULT);
			$query="INSERT into fiokok (Felhasznalonev, jelszo, admin) values(:user_name, :pwd, 0)";
			$stmt=oci_parse($con, $query);
			oci_bind_by_name($stmt, ":user_name", $user_name);
			oci_bind_by_name($stmt, ":pwd", $pwd);
			$sikeres=oci_execute($stmt);	
			//$query = "insert into fiokok (user_name,pwd) values('$user_name', '$pwd')";
			//mysqli_query($con, $query);
			if ($sikeres) {
				$_SESSION["user_name"] = $user_name;
				$query = "SELECT id from fiokok where user_name='$user_name'";
				$query_result=oci_parse($con, $query);
				oci_execute($query_result);
				$row = oci_fetch_row($query_result);
				$_SESSION["id"]=$row[0];
				$_SESSION["pwd"]=$pwd;
				header("Location: ../view/myprofile.php");
				oci_free_statement($stmt);
				die;
			}
		}
		else
		{
			$_SESSION["message"] = $problems;
			header('location: ../view/regist_page.php');
			oci_free_statement($stmt);
			die;
		}
	}
	else{
		oci_close($con);
	}
?>