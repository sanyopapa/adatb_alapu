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
    <button class="navbar-gomb" onclick="location.href= 'about.php'">Rólunk</button>
    <div class="dropgomb">
      <button class="navbar-gomb">Vonatok</button>
      <div class="dropdown">
        <a class="inactive_dropdown" href="samu.php">Samu</a>
        <a class="inactive_dropdown" href="pupos.php">Púpos</a>           
      </div>
    </div>
    <button class="navbar-gomb" onclick="location.href= 'contact.php'">Elérhetőségek</button>
    <?php
      if(isset($_SESSION["user_name"])){
        echo '
		<div class="dropgomb">
      <button class="navbar-gomb active-navbar-button">Dolgaid</button>
      <div class="dropdown">
	  	<a class="active_dropdown" href="myprofile.php">Saját profil</a>
        <a class="inactive_dropdown" href="refresh_others_page.php">Adatok módosítása</a>
        <a class="inactive_dropdown" href="refresh_pwd_page.php">Jelszó módosítása</a>
		<a class="inactive_dropdown" href="myforms.php">Beküldött űrlapjaid</a>
		<a class="inactive_dropdown" href="message/message_page.php">Beszélgetések</a>
		<a class="inactive_dropdown" href="profilesearch.php">Profilok</a>
		<a class="inactive_dropdown" href="logout.php">Kijelentkezés</a>
      </div>
    </div>';
        echo '<button class="navbar-gomb" onclick="location.href= '."'form.php'".'">Űrlap</button>';
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
			echo '<header class="container">
        	<div class="image">';
			if($_SESSION['sudo']==1){
				echo '<img class="index_pic" src="img/obj.jpg" alt="Macskával őrzött objektum"><br>';
			}
			else {
				echo '<img class="index_pic" src="'.$_SESSION["profpic_route"].'" alt="Üdvözlő kép">';
			}
        	echo '</div>
        	<div class="text1 ">
            <h1>Üdv újra, '.$_SESSION["user_name"].'</h1>
        	</div>
			<main class="torzs">';
		}
				if(isset($_SESSION["user_name"])){
					if ($latogatasok > 1) {     
						echo '<p>Ez a(z) '.$latogatasok.'. látogatásod.</p>';
					  } else {                    
						echo "Ez az 1. látogatásod.";
					  }
					if ($_SESSION['admin']==1) {
						echo "<p>Jogosultsági szinted: Adminisztrátor</p>";
					}
					if ($_SESSION['moderator']==1) {
						echo "<p>Jogosultsági szinted: Moderátor</p>";
					}
					if ($_SESSION['sudo']==1) {
						echo "<p>I hope, you won't be leváltva</p>";
					}
					echo '<form id="form-login" class="login-link" action="logout.php" method="POST">
							<input type="submit" name="btn-delete-user"  value="Kijelentkezés">
						</form>';
					echo '<form id="form-login" class="login-link" action="delete_user.php" method="POST">
							<input type="submit" name="btn-delete-user"  value="Fiók törlése">
						</form>';
				}
				else{
					header('location: login_page.php');
				}
			?>
		</main>
	</body>
</html>