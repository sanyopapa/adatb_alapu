<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$letezo_nev=$_POST['letezo_szemely'];
		$nem=$_POST['nem'];
        $szuletes=$_POST['szuletes'];
		$halal = $_POST['halal'];
		$anyja_neve=$_POST['anyja_neve'];
		$apja_neve=$_POST['apja_neve'];
		$testverek=$_POST['testverek'];
		$arr=explode(",",$testverek);
		$tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_szemelyek';
		$problems=array();
		if (!empty($szuletes) and !empty($halal) and $szletes>= $hala){
			$problems["date"]="Nem halhat meg a személy hamarabb, mint ahogy megszületett!";
		}
		if(count($problems)!=0){
			$_SESSION["message"] = $problems;
			header('location: szemely_letrehoz.php');
			mysqli_close($con);
			die;
		}
		else {
			if (!empty($nev)) {
				$query = "UPDATE ".$tabla_neve." SET nev=? where nev=?";
				//mysqli_query($con, $query);
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "si", $nev, $letezo_nev);
				$siker=mysqli_stmt_execute($stmt); 
			}
			if ($nem!="n/a") {
				$query = "UPDATE ".$tabla_neve." SET nem='$nem' where nev='" . $letezo_nev . "'";
				//mysqli_query($con, $query);
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "si", $nem, $letezo_nev);
				$siker=mysqli_stmt_execute($stmt); 
			}
			if (!empty($szuletes)) {
				$query = "UPDATE ".$tabla_neve." SET szuletes='$szuletes' where nev='" . $letezo_nev . "'";
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "si", $szuletes, $letezo_nev);
				$siker=mysqli_stmt_execute($stmt); 
				//mysqli_query($con, $query);
			}
			if (!empty($halal)) {
				$query = "UPDATE ".$tabla_neve." SET halalozas='$halal' where nev='" . $letezo_nev . "'";
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "si", $halal, $letezo_nev);
				$siker=mysqli_stmt_execute($stmt); 
				//mysqli_query($con, $query);
			}
			if (!empty($anyja_neve)) {
				$query = "UPDATE ".$tabla_neve." SET anya='$anyja_neve' where nev='" . $letezo_nev . "'";
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "si", $anyja_neve, $letezo_nev);
				$siker=mysqli_stmt_execute($stmt); 
				//mysqli_query($con, $query);
			}
			if (!empty($apja_neve)) {
				$query = "UPDATE ".$tabla_neve." SET apa='$apja_neve' where nev='" . $letezo_nev . "'";
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "si", $apja_neve, $letezo_nev);
				$siker=mysqli_stmt_execute($stmt); 
				//mysqli_query($con, $query);
			}
			if (!empty($testverek)) {
				$tabla_neve_t=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_testverek';
        		
				
				foreach ($arr as $i) {
					echo $i;		
					$query= "INSERT into ".$tabla_neve_t."(szemelyid,nev) values('$letezo_nev',?)";
					$stmt=mysqli_prepare($con, $query);
					mysqli_stmt_bind_param($stmt, "s", $i);
					mysqli_stmt_execute($stmt);
					//mysqli_query($con, $query);
			}
		}
		header("location: myprofile.php");
	}
}
        
?>