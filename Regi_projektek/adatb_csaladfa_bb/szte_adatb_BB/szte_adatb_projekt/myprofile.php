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
		<link rel="stylesheet" href="style/main_style.css?v=<?php echo time(); ?>">
		<link rel="stylesheet" href="style/form_style.css?v=<?php echo time(); ?>">
		<link rel="stylesheet" href="styles/style.css?v=<?php echo time(); ?>">
  		<link rel="stylesheet" href="styles/page_images.css?v=<?php echo time(); ?>">
  		<link rel="stylesheet" href="styles/page_content.css?v=<?php echo time(); ?>">
  		<link rel="stylesheet" href="styles/navbar.css?v=<?php echo time(); ?>">
  		<link rel="stylesheet" href="styles/dropdown.css?v=<?php echo time(); ?>">
  		<link rel="stylesheet" href="styles/animation.css?v=<?php echo time(); ?>">
  		<link rel="stylesheet" href="styles/media_size.css?v=<?php echo time(); ?>">
 		<link rel="stylesheet" href="styles/footer.css?v=<?php echo time(); ?>">
  		<link rel="icon" href="img/150_tablogo.png?v=<?php echo time(); ?>">
  		<link rel="stylesheet" href="styles/form.css?v=<?php echo time(); ?>">
	</head>
	<body>
	<nav class="navbar">
    <button class="navbar-gomb" onclick="location.href= 'index.php'">Főoldal</button>
    <button class="navbar-gomb" onclick="location.href= 'contact.php'">Névjegy</button>
    <?php
      if(isset($_SESSION["user_name"])){
        echo '
      <div class="dropgomb">
      <button class="navbar-gomb active-navbar-button">Funkciók</button>
      <div class="dropdown">
        <a class="active_dropdown" href="myprofile.php">Rögzített adatok</a>
        <a class="inactive_dropdown" href="szemely_letrehoz.php">Személy hozzáadása</a>
        <a class="inactive_dropdown" href="szemely_modosit.php">Személy módosítása</a>
        <a class="inactive_dropdown" href="esemeny_letrehoz.php">Esemény hozzáadása</a>
        <a class="inactive_dropdown" href="esemeny_modosit.php">Esemény módosítása</a>
        <a class="inactive_dropdown" href="tasks.php">Feladatokra vonatkozó megoldás</a>
        <a class="inactive_dropdown" href="refresh_pwd_page.php">Jelszó módosítása</a>
      </div>
    </div>
    <button class="navbar-gomb" onclick="location.href='."'logout.php'".'">Kijelentkezés</button>';
      }
      else {
        echo '<button class="navbar-gomb" onclick="location.href= '."'login_page.php'".'">Bejelentkezés</button>';
      }
    ?>
    <div>
      <img class="profile_pic" src="img/150_white_logo.png" alt="Fenti logó">
    </div>
  </nav>
	<?php
		if(isset($_SESSION["user_name"])){
        	echo '
        	<div class="text1">
            <h1><br></h1>
			<h1>Üdv újra, '.$_SESSION["user_name"].'</h1>
			<h1><br></h1>
        	</div>
			<main class="torzs">';
			}
		echo '<div class="form_2">';
			if(isset($_SESSION["user_name"])){
				echo '<form id="form-login" class="login-link" action="csaladfa_creator.php" method="POST">
				<label for="">Ezzel a gombbal létrehozhatsz egy családfát.</label><br><br>
				<input type="text" id="user-name" name="csalad_neve" size="25" placeholder="Ide írd be a család nevét!"><br><br>
				<input type="submit" name="btn-create-csaladfa"  value="Létrehozás">
				</form><br><br>';
				include("connection.php");
				$query = "SELECT nev from csaladfa_sum where letrehozo = ".'"'.$_SESSION["user_name"].'" order by nev';
				$query_result = mysqli_query($con, $query);
				if (mysqli_num_rows($query_result)==0) {
					echo '<p>Jelenleg nincs létrehozott családod!</p>';
				}
				else {
					$csaladnev=$_SESSION["akt_csaladnev"];
					if (empty($csaladnev)) {
						echo '<p>Nem választottál ki egy családot sem!</p><br>';
					}
					else 
					{
						echo '
						<p>A kiválasztott család: '.$csaladnev.'</p><br>';
					}
					echo '<table>
					<thead>
						<tr>
							<th class="table_header">Családjaid neve:</th>
							<th class="table_header">Kiválasztás</th>
						</tr>
					</thead>
					<tbody>';
					while ($row = mysqli_fetch_row($query_result)) {
					echo '<tr>
							<th class="table_odd">'.$row[0].'</th>
							<th class="table_odd">
								<form id="form-login" class="login-link" action="kivalaszt_csalad.php" method="POST">
								<input type="hidden" name="csaladnev" value='.$row[0].'>
								<input type="submit" value="Kiválasztás">
								</form>
							</th>
						</tr>';
				  }
				  echo '</tbody> </table><br>';
				  
				if (!empty($csaladnev)) {
				$tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_szemelyek';
				  $query="SELECT id, nev from ".$tabla_neve;
				  $query_result = mysqli_query($con, $query);
				  
				  if (mysqli_num_rows($query_result)==0) {
					echo '<p>Jelenleg nincs egy tagja sem a családnak!</p><br>';
					}
					else {
						echo '<table>
						<thead>
							<tr>
								<th class="table_header">'.$csaladnev.' család tagjai:</th>
								<th class="table_header">Családtag törlése</th>
							</tr>
						</thead>
						<tbody>';
						while ($row = mysqli_fetch_row($query_result)) {
							echo '<tr>
								<th class="table_odd">'.$row[1].'</th>
								
								<th class="table_odd">
									<form id="form-login" class="login-link" action="csaladtag_torlese.php" method="POST">
									<input type="hidden" name="szemelynev_id" value="'.$row[0].'">
									<input type="hidden" name="szemelynev" value="'.$row[1].'">
									<input type="submit" value="Törlés">
									</form>
								</th>
							</tr>';
					}
					
					echo '</tbody></table><br>';
					}
        			
					$tabla_neve_e=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_esemenyek';
					$query="SELECT e.id, p1.nev AS egyik_szemely_neve, p2.nev AS masik_szemely_neve, e.hazassag_datum, e.valas_datum
					FROM $tabla_neve_e AS e
					JOIN $tabla_neve AS p1 ON e.szemelyid = p1.id
					JOIN $tabla_neve AS p2 ON erintett_id = p2.id";
					$query_result = mysqli_query($con, $query);
					if (mysqli_num_rows($query_result)==0) {
						echo '<p>Jelenleg nincs egy eseménye sem a kért családnak</p>';
					}
					else {
						echo '
						<table>
						<thead>
							<tr>
							<th class="table_header" colspan="5">'.$_SESSION["akt_csaladnev"].' család életeseményei:</th>
							</tr>
							<tr>
								<th class="table_header">Egyik érintett neve</th>
								<th class="table_header">Másik érintett neve</th>
								<th class="table_header">Házasság dátuma</th>
								<th class="table_header">Válás dátuma</th>
								<th class="table_header">Esemény törlése</th>
							</tr>
						</thead>
						<tbody>';
						while ($rows = mysqli_fetch_row($query_result)) {
							echo '<tr>
								<th class="table_odd">'.$rows[1].'</th>
								<th class="table_odd">'.$rows[2].'</th>
								<th class="table_odd">'.$rows[3].'</th>';
								if ($rows[4]=="0000-00-00") {
									echo '<th class="table_odd">Még boldog házasok</th>';
								}
								else {
									echo '<th class="table_odd">'.$rows[4].'</th>';

								}
								echo '<th class="table_odd">
									<form id="form-login" class="login-link" action="esemeny_torlese.php" method="POST">
									<input type="hidden" name="esemeny_id" value="'.$rows[0].'">
									<input type="submit" value="Törlés">
									</form>
								</th>
							</tr>';
						}
						echo '</tbody>';
					}
					echo '</table><br>';
						
					
					echo '<form id="form-login" class="login-link" action="delete_user.php" method="POST">
					<label for="">Ezzel a gombbal törölheted a fiókod.</label><br>
					<input type="submit" name="btn-delete-user"  value="Fiók törlése">
					</form>';
				}
			}
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