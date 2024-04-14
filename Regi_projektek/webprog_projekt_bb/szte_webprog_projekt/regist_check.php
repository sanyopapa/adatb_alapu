<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$user_name = $_POST['user-name'];
		$pwd = $_POST['pwd'];
		$pwd_2 = $_POST['pwd-2'];
		$email = $_POST['email'];
		
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
		if(empty($email)){
			$problems['email'] = 'Email címet kötelező megadni!';
		}
		$query = "select * from users where user_name = '$user_name' limit 1";
		$query_result = mysqli_query($con, $query);
		if($query_result && mysqli_num_rows($query_result) > 0){
			$problems['user_name'] = 'Ez a felhasználónév foglalt.';
		}
		$query = "select * from users where email = '$email' limit 1";
		$query_result = mysqli_query($con, $query);
		if($query_result && mysqli_num_rows($query_result) > 0){
			$problems['email'] = 'Ez az e-mail cím használva van';
		}
		if(count($problems)==0){
			$pwd = password_hash($pwd, PASSWORD_DEFAULT);		
			$query = "insert into users (user_name,pwd,email) values('$user_name', '$pwd', '$email')";
			mysqli_query($con, $query);
			$_SESSION["user_name"] = $user_name;
			$query = "SELECT id from users where user_name='$user_name'";
			$query_result=mysqli_query($con, $query);
			$row = mysqli_fetch_row($query_result);
			$_SESSION["id"]=$row[0];
			$_SESSION["pwd"]=$pwd;
			$_SESSION["email"]=$email;
			$_SESSION["birth"]=null;
			$_SESSION["intro"]="";
			$_SESSION["admin"] =0;
			$_SESSION["moderator"] =0;
			$_SESSION["sudo"] =0;
			$_SESSION["email_vis"]=0;
			$_SESSION["birth_vis"]=0;
			$_SESSION["profpic_route"]="img/welcome_01.png";

			header("Location: myprofile.php");
			mysqli_close($con);
			die;
		}
		else{
			$_SESSION["message"] = $problems;
			header('location: regist_page.php');
			mysqli_close($con);
			die;
		}
	}
	else{
		mysqli_close($con);
	}
	

?>