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
		$query = "select * from fiokok where user_name = '$user_name' limit 1";
		$query_result = mysqli_query($con, $query);
		if($query_result && mysqli_num_rows($query_result) > 0){
			$problems['user_name'] = 'Ez a felhasználónév foglalt.';
		}
		$query = "select * from fiokok where email = '$email' limit 1";
		if(count($problems)==0){
			$pwd = password_hash($pwd, PASSWORD_DEFAULT);
			$query="INSERT into fiokok (user_name,pwd) values(?, ?)"
			$stmt=mysqli_prepare($con,$query);
			mysqli_stmt_bind_param($stmt, "ss", $user_name, $pwd);
			$sikeres=mysqli_stmt_execute($stmt);	
			//$query = "insert into fiokok (user_name,pwd) values('$user_name', '$pwd')";
			//mysqli_query($con, $query);
			if ($sikeres) {
				$_SESSION["user_name"] = $user_name;
				$query = "SELECT id from fiokok where user_name='$user_name'";
				$query_result=mysqli_query($con, $query);
				$row = mysqli_fetch_row($query_result);
				$_SESSION["id"]=$row[0];
				$_SESSION["pwd"]=$pwd;
				header("Location: myprofile.php");
				mysqli_stmt_close($con);
				die;
			}
		}
		else
		{
			$_SESSION["message"] = $problems;
			header('location: regist_page.php');
			mysqli_stmt_close($con);
			die;
		}
	}
	else{
		mysqli_close($con);
	}
?>