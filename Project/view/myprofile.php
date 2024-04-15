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
			<main class="torzs">';
			}
			
			
			
			// Connect to the Oracle database
			include("../controller/connection.php");

			

			// Prepare the SQL query
			$query = "SELECT id, Tipus, Kezdet FROM Vasarol WHERE email = '" . $_SESSION['user_name'] . "' ORDER BY Kezdet DESC";

			// Execute the query
			$statement = oci_parse($con, $query);
			oci_execute($statement);

			// Fetch the results and display the buttons
			while ($row = oci_fetch_assoc($statement)) {
				$id = $row['ID'];
				$tipus = $row['TIPUS'];
				$kezs = $row['KEZDET'];
				echo '<form action="../controller/jegy_torol.php" method="POST">';
				echo '<input type="hidden" name="tipus" value="' . $id . '">
				<label>'.$tipus.'</label>
				<label><br>'.$kezs.'</label><br>';
				echo '<input type="submit" name="submit" value="Törlés">';
				echo '</form>';
			}
			/*
			<form id="form-login" class="login-link" action="csaladtag_torlese.php" method="POST">
									<input type="hidden" name="szemelynev_id" value="'.$row[0].'">
									<input type="hidden" name="szemelynev" value="'.$row[1].'">
									<input type="submit" value="Törlés">			
			*/
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