<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$user_name = $_POST['user-name'];
        $email=$_POST['email'];
        $birth=$_POST['birth'];
		$intro = $_POST['intro'];
		$birth_vis=$_POST['birth_vis'];
		$email_vis=$_POST['email_vis'];
        $pwd=$_POST['pwd'];
		$mod=$_POST['mod'];
		

		$problems = array();

		if(is_numeric($user_name)){
			$problems['user_name'] = 'A felhasználónévnek betűt kell tartalmaznia.';
		}
		if(strlen($pwd)<6 and strlen($pwd)>0){
			$problems['pwd'] = 'Az új jelszónak 6 karakter hosszúnak kell lennie.';
		}

		$query = "select * from users where user_name = '$user_name' limit 1";
		$query_result = mysqli_query($con, $query);
		if($query_result && mysqli_num_rows($query_result) > 0){
			$problems['user_name'] = 'Ez a felhasználónév foglalt.';
		}

        if(count($problems)==0){
			
            if (!empty($pwd)) {
                $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                $query = "UPDATE users SET pwd='$pwd' where id='" . $_SESSION["masid"] . "'";
				mysqli_query($con, $query);
            }
            if (!empty($email)) {
				$query = "UPDATE users SET email='$email' where id='" . $_SESSION["masid"] . "'";
				mysqli_query($con, $query);
            }
			if (!empty($user_name)) {
				$query = "UPDATE users SET user_name='$user_name' where id='" . $_SESSION["masid"] . "'";
				mysqli_query($con, $query);
			}
            if (!empty($birth)) {
                $query = "UPDATE users SET birth='$birth' where id='" . $_SESSION["masid"] . "'";
                mysqli_query($con, $query);
            }
            if (!empty($intro)) {
				$query = "UPDATE users SET intro='$intro' where id='" . $_SESSION["masid"] . "'";
            	mysqli_query($con, $query);
			}
			if (empty($birth_vis)) {
				$query = "UPDATE users SET birth_vis=0 where id='" . $_SESSION["masid"] . "'";
            	mysqli_query($con, $query);
			}
			else {
				$query = "UPDATE users SET birth_vis=1 where id='" . $_SESSION["masid"] . "'";
            	mysqli_query($con, $query);
			}
			if (empty($email_vis)) {
				$query = "UPDATE users SET email_vis=0 where id='" . $_SESSION["masid"] . "'";
            	mysqli_query($con, $query);
			}
			else {
				$query = "UPDATE users SET email_vis=1 where id='" . $_SESSION["masid"] . "'";
            	mysqli_query($con, $query);
			}
			if (empty($mod)) {
				$query = "UPDATE users SET moderator=0 where id='" . $_SESSION["masid"] . "'";
            	mysqli_query($con, $query);
			}
			else {
				$query = "UPDATE users SET moderator=1 where id='" . $_SESSION["masid"] . "'";
            	mysqli_query($con, $query);
			}
			if (empty($sudo)) {
				$query = "UPDATE users SET sudo=0 where id='" . $_SESSION["masid"] . "'";
            	mysqli_query($con, $query);
			}
			else {
				$query = "UPDATE users SET sudo=1 where id='" . $_SESSION["masid"] . "'";
            	mysqli_query($con, $query);
			}
			header("Location: myprofile.php");
			mysqli_close($con);
			die;
		}
		else{
			$_SESSION["message"] = $problems;
			header('location: otherprofiles.php');
			mysqli_close($con);
			die;
		}
	}
	else{
		
		mysqli_close($con);
	}
?>