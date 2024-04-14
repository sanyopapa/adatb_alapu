<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$lok_name = $_POST['lok_name'];
        $lok_type=$_POST['lok_type'];
		$lok_reason = $_POST['lok_reason'];
        $id=$_SESSION["id"];
		$problems = array();

		if(is_numeric($user_name)){
			$problems['user_name'] = 'A felhasználónévnek betűt kell tartalmaznia.';
		}

        if(count($problems)==0){
            $query = "insert into forms (sajatid,lok_name,lok_type,lok_reason) values('$id', '$lok_name', '$lok_type','$lok_reason')";
            mysqli_query($con, $query);
            $form_success="A feltöltés sikeres volt.";
			header("Location: form.php");
			mysqli_close($con);
			die;
		}
		else{
			$_SESSION["message"] = $problems;
			header('location: refresh_others_page.php');
			mysqli_close($con);
			die;
		}
	}
	else{
		mysqli_close($con);
	}
?>