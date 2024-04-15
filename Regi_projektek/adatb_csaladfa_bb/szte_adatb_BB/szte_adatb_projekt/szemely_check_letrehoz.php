<?php
	if(!isset($_SESSION)){session_start();}
	include("connection.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$nev = $_POST['nev'];
		$nem=$_POST['nem'];
        $szuletes=$_POST['szuletes'];
		$halal = $_POST['halal'];
		$anyja_neve=$_POST['anyja_neve'];
		$apja_neve=$_POST['apja_neve'];
		$testverek=$_POST['testverek'];
		$arr=explode(",",$testverek);
		$tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_szemelyek';
		$problems=array();
		if ($szuletes>= $halal and !empty($halal)) {
			$problems["date"]="Nem halhat meg a személy hamarabb, mint ahogy megszületett!";
		}
		if(count($problems)!=0){
			$_SESSION["message"] = $problems;
			header('location: szemely_letrehoz.php');
			mysqli_close($con);
			die;
		}
		else {
			$query = "INSERT into ".$tabla_neve."(nev,nem,szuletes,halalozas,anya,apa) values(?,?,?,?,?,?)";
			//mysqli_query($con, $query);
			$stmt=mysqli_prepare($con, $query);
			mysqli_stmt_bind_param($stmt, "ssssss", $nev, $nem,$szuletes,$halal,$anyja_neve,$apja_neve);
			$sikeres=mysqli_stmt_execute($stmt);
			if (!empty($testverek)) {
				$tabla_neve_t=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_testverek';
				$query="SELECT id from $tabla_neve where nev=?"; 
				$stmt=mysqli_prepare($con, $query);
				mysqli_stmt_bind_param($stmt, "s", $nev);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				mysqli_stmt_bind_result($stmt, $result)
				//$query_result = mysqli_query($con, $query);
        		
				echo $result;
				foreach ($arr as $i) {
					echo $i;		
					$query= "INSERT into ".$tabla_neve_t."(szemelyid,nev) values('$result',?)";
					$stmt=mysqli_prepare($con, $query);
					mysqli_stmt_bind_param($stmt, "s", $i);
					mysqli_stmt_execute($stmt);
					//mysqli_query($con, $query);
				}
			}
			if ($siker) header("location: myprofile.php");
		}
	}      
?>