<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$id=$_POST["letezo_esemeny"];
		$egyik_szemely=$_POST["egyik_szemely"];
		$masik_szemely=$_POST["masik_szemely"];
		$hazassag=$_POST["hazassag"];
		$valas=$_POST["valas"];

		$problems=array();

		$tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_esemenyek';
		$query="SELECT hazassag_datum, valas_datum from $tabla_neve where id=$id";
		$result=mysqli_query($con,$query);
		$row=mysqli_fetch_row($result);
		if (($hazassag>= $valas and !empty($hazassag) and !empty($valas))
		or ($row[1]!="0000-00-00" and $row[0]>$valas or $row[1]<$hazassag)){
			$problems["date"]="Nem válhatsz el hamarabb, mint ahogy összeházasodtál!!";
		}

		if (!empty($egyik_szemely) and !empty($masik_szemely)) {
			if ($egyik_szemely== $masik_szemely){
				$problems["same"]="Két teljesen azonos személy nem köthet házasságot!";
			}
			$query="SELECT id from $tabla_neve where valas_datum=0 and (szemelyid=$egyik_szemely or szemelyid=$masik_szemely or erintett_id=$egyik_szemely or erintett_id=$masik_szemely)";
			$query_result=mysqli_query($con, $query);
			if (mysqli_num_rows($query_result)!=0) {
				$problems["foglalt"]="Az egyik illető foglalt már!";
	
			}		
		}
		if(count($problems)!=0){
			$_SESSION["message"] = $problems;
			header('location: esemeny_modosit.php');
			mysqli_close($con);
			die;
		}
		else{
			$tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_szemelyek';
			$query="SELECT id from $tabla_neve where nev='".$_SESSION["akt_szemelynev"]."'";
			$query_result=mysqli_query($con, $query);
			$rows=mysqli_fetch_row($query_result);
			$tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_esemenyek';
			if (!empty($egyik_szemely)) {
				$query = "UPDATE ".$tabla_neve." SET szemelyid=? where id=?";
				//mysqli_query($con, $query);
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "ii", $egyik_szemely, $id);
				$siker=mysqli_stmt_execute($stmt); 
			}
			if (!empty($masik_szemely)) {
				$query = "UPDATE ".$tabla_neve." SET erintett_id=? where id=?";
				//mysqli_query($con, $query);
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "ii", $masik_szemely, $id);
				$siker=mysqli_stmt_execute($stmt); 
			}
			if (!empty($hazassag)) {
				$query = "UPDATE ".$tabla_neve." SET valas_datum=? where id=?";
				//mysqli_query($con, $query);
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "si", $valas, $id);
				$siker=mysqli_stmt_execute($stmt); 
			}
			if (!empty($valas)) {
				$query = "UPDATE ".$tabla_neve." SET hazassag_datum=? where id=?";
				//mysqli_query($con, $query);
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "si", $hazassag, $id);
				$siker=mysqli_stmt_execute($stmt); 
			}
			//mysqli_query($con, $query);
			if ($siker) header("location: myprofile.php");
		}
		
		
	}
	else{
		mysqli_close($con);
	}
?>