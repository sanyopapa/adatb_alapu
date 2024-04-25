<?php
if (!isset($_SESSION)) {
	session_start();
}
?>

<?php
$latogatasok = 1;
if (isset($_COOKIE["visits"])) {
	$latogatasok = $_COOKIE["visits"] + 1;
}
setcookie("visits", $latogatasok, time() + (60 * 60 * 24 * 30), "/");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>R150 - Dolgaid</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../styles/style.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="../styles/page_images.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="../styles/page_content.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="../styles/navbar.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="../styles/dropdown.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="../styles/animation.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="../styles/media_size.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="../styles/footer.css?v=<?php echo time(); ?>">
	<link rel="icon" href="../img/150_tablogo.png?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="../styles/form.css?v=<?php echo time(); ?>">
</head>

<body>
	<nav>
		<?php include 'navbar.php' ?>
	</nav>

	<?php
	if (isset($_SESSION["user_name"])) {
		echo '
		<main class="torzs table_div">
		<div class="text1">
		
		<h1>Üdv újra, ' . $_SESSION["name"] . '</h1>
		<h1><br></h1>
		</div>
		';
	}

	// Connect to the Oracle database
	include("../controller/connection.php");

	// Prepare the SQL query
	$query = "SELECT v.id, v.Email, v.Tipus, v.Kezdet, j.Idotartam, j.Ar,
				CASE 
					WHEN (v.Kezdet + j.Idotartam) >= CURRENT_DATE THEN 'Érvényes'
					ELSE 'Lejárt'
				END AS Ervenyesseg
				FROM Vasarol v
				JOIN Jegy j ON v.Tipus = j.Tipus
				WHERE v.Email = :email
				order by v.Kezdet desc";

	// Execute the query
	$statement = oci_parse($con, $query);
	oci_bind_by_name($statement, ":email", $_SESSION["user_name"]);
	oci_execute($statement);

	// Fetch the results and display the buttons
	if (oci_fetch($statement)) {
		echo '<table>
		<thead>
		<tr>
			<th colspan="5" class="table_header">Jegyeid:</th>
		</tr>
		<tr>
			<th class="table_header">Jegy típusa</th>
			<th class="table_header">Kezdete</th>
			<th class="table_header">Érvényes-e?</th>
			<th class="table_header">Ára</th>
			<th class="table_header">Törlés</th>
		</tr>
		</thead>
		<tbody>';
		$stmt = oci_parse($con, $query);
		oci_bind_by_name($stmt, ":email", $_SESSION["user_name"]);
		oci_execute($stmt);
		$count = 0;
		while ($row = oci_fetch_assoc($stmt)) {
			$id = $row['ID'];
			$tipus = $row['TIPUS'];
			$date = DateTime::createFromFormat('d-M-y', $row['KEZDET']);
			$formatted_date = date_format($date, 'Y. F j.');
			$ar = $row['AR'];
			$kezs = $row['KEZDET'];
			$ervenyesseg = $row['ERVENYESSEG'];
			$class = $count % 2 == 1 ? 'table_even' : 'table_odd';
			echo '<tr>
			<td class="' . $class . '">' . $tipus . '</td>
			<td class="' . $class . '">' . $formatted_date . '</td>
			<td class="' . $class . '">' . $ervenyesseg . '</td>
			<td class="' . $class . '">' . $ar . ' Ft</td>
			<td class="' . $class . '">
			<form action="../controller/jegy_torol.php" method="POST">
			<input type="hidden" name="tipus" value="' . $id . '">
			<input type="submit" name="submit" value="Törlés">
			</form>
			</td>
			</tr>';
			$count++;
		}
		echo '</tbody></table>';
	}

	$query = "SELECT SUM(j.Ar) AS Osszeg
		FROM Vasarol v
		JOIN Jegy j ON v.Tipus = j.Tipus
		WHERE v.Email = :email";

	$statement = oci_parse($con, $query);
	oci_bind_by_name($statement, ":email", $_SESSION["user_name"]);
	oci_execute($statement);

	if (oci_fetch($statement)) {
		$osszeg = oci_result($statement, "OSSZEG");
		echo "<p>Eddigi költéseim: " . $osszeg . " Ft</p>";
	}

	oci_close($con);
	?>
	<table>
		<tbody>
			<tr>
				<td class = "table_even">Veled egyidős vonat(ok)</td>
				<td class="table_even">
					<?php
					$currentYear = date("Y");
					$userEmail = $_SESSION["user_name"];

					$query = "SELECT S.SzNev, S.Gyartasi_ev
					FROM Szerelveny S, Felhasznalo F
					WHERE S.Gyartasi_ev = (EXTRACT(YEAR FROM SYSDATE) - F.Eletkor)
					AND F.Email = :userEmail";

					$statement = oci_parse($con, $query);
					oci_bind_by_name($statement, ':userEmail', $userEmail);
					oci_execute($statement);

					$rowCount = oci_fetch_all($statement, $result);
					if ($rowCount > 0) {
						foreach ($result['SZNEV'] as $trainName) {
							echo "" . ($trainName !== null ? htmlentities($trainName, ENT_QUOTES) : "&nbsp;") . "<br>";
						}
					} else {
						echo "Nincs veled egyidős vonat.";
					}
					?>
				</td>
			</tr>
			<tr>
				<td class = "table_odd">Nálad idősebb vonat(ok)</td>
				<td class = "table_odd">
				<?php
				$currentYear = date("Y");
				$userEmail = $_SESSION["user_name"];

				$query = "SELECT S.SzNev, S.Gyartasi_ev
				FROM Szerelveny S, Felhasznalo F
				WHERE S.Gyartasi_ev < (EXTRACT(YEAR FROM SYSDATE) - F.Eletkor)
				AND F.Email = :userEmail";

				$statement = oci_parse($con, $query);
				oci_bind_by_name($statement, ':userEmail', $userEmail);
				oci_execute($statement);

				$rowCount = oci_fetch_all($statement, $result);
				if ($rowCount > 0) {
					foreach ($result['SZNEV'] as $trainName) {
						echo "" . ($trainName !== null ? htmlentities($trainName, ENT_QUOTES) : "&nbsp;") . "<br>";
					}
				} else {
					echo "Nincs nálad idősebb vonat.";
				}
				?>
				</td>
			</tr>
			<tr>
				<td class = "table_even">Nálad fiatalabb vonat(ok)</td>
				<td class = "table_even">
				<?php
				$currentYear = date("Y");
				$userEmail = $_SESSION["user_name"];

				$query = "SELECT S.SzNev, S.Gyartasi_ev
				FROM Szerelveny S, Felhasznalo F
				WHERE S.Gyartasi_ev > (EXTRACT(YEAR FROM SYSDATE) - F.Eletkor)
				AND F.Email = :userEmail";

				$statement = oci_parse($con, $query);
				oci_bind_by_name($statement, ':userEmail', $userEmail);
				oci_execute($statement);

				$rowCount = oci_fetch_all($statement, $result);
				if ($rowCount > 0) {
					foreach ($result['SZNEV'] as $trainName) {
						echo "" . ($trainName !== null ? htmlentities($trainName, ENT_QUOTES) : "&nbsp;") . "<br>";
					}
				} else {
					echo "Nincs nálad fiatalabb vonat.";
				}
				?>
				</td>
			</tr>
		</tbody>
	</table>

	<?php
	if (isset($_SESSION["user_name"])) {
		echo '<form id="form-login" class="login-link" action="../controller/delete_user.php" method="POST">
		<label for="">Ezzel a gombbal törölheted a fiókod.</label><br><br>
		<input type="submit" name="btn-delete-user" value="Fiók törlése">
		</form><br>';
	} else {
		header('location: login_page.php');
	}
	?>

</main>

<footer id="footer" class="unselectable">
	<p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p>
</footer>

</body>

</html>
