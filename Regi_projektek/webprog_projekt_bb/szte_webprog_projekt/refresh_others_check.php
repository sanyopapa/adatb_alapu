<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$user_name = $_POST['user-name'];
        $birth=$_POST['birth'];
		$intro = $_POST['intro'];
		$birth_vis=$_POST['birth_vis'];
		$email_vis=$_POST['email_vis'];
		$email=$_POST['email'];
		$problems = array();
		if(is_numeric($user_name)){
			$problems['user_name'] = 'A felhasználónévnek betűt kell tartalmaznia.';
		}
		$query = "select * from users where user_name = '$user_name' limit 1";
		$query_result = mysqli_query($con, $query);
		if($query_result && mysqli_num_rows($query_result) > 0){
			$problems['user_name'] = 'Ez a felhasználónév foglalt.';
		}

        if(count($problems)==0){

			if (!empty($email)) {
				$query = "UPDATE users SET email='$email' where id='" . $_SESSION["id"] . "'";
				mysqli_query($con, $query);
				$_SESSION["email"] = $email;
			}
			if (!empty($user_name)) {
				$query = "UPDATE users SET user_name='$user_name' where id='" . $_SESSION["id"] . "'";
				mysqli_query($con, $query);
				$_SESSION["user_name"] = $user_name;
			}
            if (!empty($birth)) {
                $query = "UPDATE users SET birth='$birth' where id='" . $_SESSION["id"] . "'";
                mysqli_query($con, $query);
			    $_SESSION["birth"] = $birth;
            }
            if (!empty($intro)) {
				$query = "UPDATE users SET intro='$intro' where id='" . $_SESSION["id"] . "'";
            	mysqli_query($con, $query);
				$_SESSION["intro"] = $intro;
			}
			if (empty($birth_vis)) {
				$query = "UPDATE users SET birth_vis=0 where id='" . $_SESSION["id"] . "'";
            	mysqli_query($con, $query);
				$_SESSION["birth_vis"]=0;
			}
			else {
				$query = "UPDATE users SET birth_vis=1 where id='" . $_SESSION["id"] . "'";
            	mysqli_query($con, $query);
				$_SESSION["birth_vis"]=1;
			}
			if (empty($email_vis)) {
				$query = "UPDATE users SET email_vis=0 where id='" . $_SESSION["id"] . "'";
            	mysqli_query($con, $query);
				$_SESSION["email_vis"]=0;
			}
			else {
				$query = "UPDATE users SET email_vis=1 where id='" . $_SESSION["id"] . "'";
            	mysqli_query($con, $query);
				$_SESSION["email_vis"]=1;
			}
			header("Location: myprofile.php");
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
<?php
  
?>
