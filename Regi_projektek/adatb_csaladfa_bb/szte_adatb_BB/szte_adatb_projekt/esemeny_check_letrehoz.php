<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$egyik_szemely=$_POST["egyik_szemely"];
		$masik_szemely=$_POST["masik_szemely"];
		$hazassag=$_POST["hazassag"];
		$valas=$_POST["valas"];
		$problems=array();
		$tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_esemenyek';
		if ($egyik_szemely== $masik_szemely){
			$problems["same"]="Két teljesen azonos személy nem köthet házasságot!";
		}
		if ($hazassag>= $valas and !empty($valas)){
			$problems["date"]="Nem válhatsz el hamarabb, mint ahogy összeházasodtál!!";
		}
		$query="SELECT id from $tabla_neve where valas_datum=0 and (szemelyid=$egyik_szemely or szemelyid=$masik_szemely or erintett_id=$egyik_szemely or erintett_id=$masik_szemely)";
		$query_result=mysqli_query($con, $query);
		if (mysqli_num_rows($query_result)!=0) {
			$problems["foglalt"]="Az egyik illető foglalt már!";

		}		
		
		if(count($problems)!=0){
			$_SESSION["message"] = $problems;
			header('location: esemeny_letrehoz.php');
			mysqli_close($con);
			die;
		}
		else {			
			$query = "INSERT into ".$tabla_neve."(szemelyid,hazassag_datum,valas_datum,erintett_id) values(?,?,?,?)";
			//mysqli_query($con, $query);
			$stmt=mysqli_prepare($con, $query);
			mysqli_stmt_bind_param($stmt, "issi", $egyik_szemely, $hazassag, $valas, $masik_szemely)
			$siker=mysqli_stmt_execute($stmt); 
			if ($siker) {
				header("location: myprofile.php");
			}	
		}
	}
	else{
		mysqli_close($con);
	}
?>