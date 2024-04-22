<?php
	if(!isset($_SESSION)){session_start();}
?>
<?php
  $latogatasok = 1;
  if (isset($_COOKIE["visits"])) {
    $latogatasok = $_COOKIE["visits"] + 1;  
  }
  setcookie("visits", $latogatasok, time() + (60*60*24*30), "/");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>R150 - Dolgaid</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="PHP examples.">
		<link rel="stylesheet" href="../style/main_style.css?v=<?php echo time(); ?>">
		<link rel="stylesheet" href="../style/form_style.css?v=<?php echo time(); ?>">
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
		if(isset($_SESSION["user_name"])){
        	echo '
        	<div class="text1">
            <h1><br></h1>
			<h1>Üdv újra, '.$_SESSION["name"].'</h1>
			<h1><br></h1>
        	</div>
			<main class="torzs table_div">';
			}
			
			
			
			// Connect to the Oracle database
			include("../controller/connection.php");

			

			// Prepare the SQL query
			$query = "SELECT v.id, v.Email, v.Tipus, v.Kezdet, j.Idotartam,
						CASE 
							WHEN (v.Kezdet + j.Idotartam) >= CURRENT_DATE THEN 'Érvényes'
							ELSE 'Lejárt'
						END AS Ervenyesseg
						FROM Vasarol v
						JOIN Jegy j ON v.Tipus = j.Tipus
						WHERE v.Email = :email
						order by v.Kezdet desc
						";

			// Execute the query
			$statement = oci_parse($con, $query);
			oci_bind_by_name($statement, ":email", $_SESSION["user_name"]);
			oci_execute($statement);

	

			// Fetch the results and display the buttons
			if (oci_fetch($statement)) {
				echo '<table>
				<thead>
                <tr>
                    <th colspan="4" class="table_header">Jegyeid:</th>
                </tr>
				<tr>
					<th class="table_header">Jegy típusa</th>
					<th class="table_header">Kezdete</th>
					<th class="table_header">Érvényes-e?</th>
					<th class="table_header">Törlés</th>
				</tr>
            	</thead>
				<tbody>';
				$stmt = oci_parse($con, $query);
				oci_bind_by_name($stmt, ":email", $_SESSION["user_name"]);
				oci_execute($stmt);
				$count=0;
				while ($row = oci_fetch_assoc($stmt)) {
					$id = $row['ID'];
					$tipus = $row['TIPUS'];
					$date = DateTime::createFromFormat('d-M-y', $row['KEZDET']);
					$formatted_date = date_format($date, 'Y. F j.');
					
					$kezs = $row['KEZDET'];
					$ervenyesseg = $row['ERVENYESSEG'];
					$class = $count % 2 == 1 ? 'table_even' : 'table_odd';
					echo '<tr>
					<td class="'.$class.'">' . $tipus . '</td>
					<td class="'.$class.'">' . $formatted_date . '</td>
					<td class="'.$class.'">' . $ervenyesseg . '</td>
					<td class="'.$class.'">
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
			
			// Close the connection
			oci_close($con);
			

			if(isset($_SESSION["user_name"])){
			
			echo '<form id="form-login" class="login-link" action="../controller/delete_user.php" method="POST">
			<label for="">Ezzel a gombbal törölheted a fiókod.</label><br>
			<input type="submit" name="btn-delete-user"  value="Fiók törlése">
			</form>';
			}
				
				
				else {
					header('location: login_page.php');
				}
			?>
			</div>
		</main>
		<footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
	</body>
</html>