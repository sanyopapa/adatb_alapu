<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$pwd = $_POST['pwd'];
		$pwd_2 = $_POST['pwd-2'];
		$email = $_POST['email'];
		$nev = $_POST['nev'];
		$eletkor = $_POST['eletkor'];
		$kedvezmenytipus = $_POST['kedvezmenytipus'];
		$igazolvanyszam = $_POST['igazolvanyszam'];
		
		$problems = array();
		
		
		if(strlen($email)==0){
			$problems['email'] = 'Az email cím nem lehet üres!';
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
			$query="INSERT into Felhasznalo (Email, Jelszo, Nev, Eletkor, Kedvezmenytipus, Igazolvanyszam, Admin) values(:email, :pwd, :nev, :eletkor, :kedvezmenytipus, :igazolvanyszam, 0)";
			$stmt=oci_parse($con, $query);
			oci_bind_by_name($stmt, ":email", $email);
			oci_bind_by_name($stmt, ":pwd", $pwd);
			oci_bind_by_name($stmt, ":nev", $nev);
			oci_bind_by_name($stmt, ":eletkor", $eletkor);
			oci_bind_by_name($stmt, ":kedvezmenytipus", $kedvezmenytipus);
			oci_bind_by_name($stmt, ":igazolvanyszam", $igazolvanyszam);
			$sikeres=oci_execute($stmt);	
			//$query = "insert into fiokok (user_name,pwd) values('$user_name', '$pwd')";
			//mysqli_query($con, $query);
			if ($sikeres) {
				$_SESSION["user_name"] = $email;
				$query = "SELECT $email from Felhasznalo where email='$email'";
				$query_result=oci_parse($con, $query);
				oci_execute($query_result);
				$row = oci_fetch_row($query_result);
				$_SESSION["id"]=$row[0];
				$_SESSION["pwd"]=$pwd;
				$_SESSION["name"]=$nev;
				$_SESSION["admin"]=0;
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