<?php
	if(!isset($_SESSION)){session_start();}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>R150 - Profilok</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="PHP examples.">
		<link rel="stylesheet" href="style/main_style.css?v=<?php echo time(); ?>">
		<link rel="stylesheet" href="style/form_style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="style/profiles.css?v=<?php echo time(); ?>">
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
	  	<a class="inactive_dropdown" href="myprofile.php">Saját profil</a>
        <a class="inactive_dropdown" href="refresh_others_page.php">Adatok módosítása</a>
        <a class="inactive_dropdown" href="refresh_pwd_page.php">Jelszó módosítása</a>
		<a class="inactive_dropdown" href="myforms.php">Beküldött űrlapjaid</a>
		<a class="inactive_dropdown" href="message/message_page.php">Beszélgetések</a>
    <a class="active_dropdown" href="profilesearch.php">Profilok</a>
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
    if(isset($_SESSION["user_name"])) {
      echo '<header id="form_1">
      <div class="text1">
          <h1>Regisztrált emberek listája:</h1>
      </div>
    </header>';
    } ?>
    <main class="profiles_div">
    <?php
    $query = "SELECT user_name from users where user_name != '" . $_SESSION['user_name'] . "' and admin=1 order by user_name";
    include("connection.php");
    $query_result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_row($query_result)) {
      echo '<form method="POST" action="otherprofiles.php">
      <label for="name">Admin</label><br>
      <input type="hidden" name="name" value='.$row[0].'>
      <input type="submit" value='.$row[0].'>
        </form>';
    }
    $query = "SELECT user_name from users where user_name != '" . $_SESSION['user_name'] . "' and moderator=1 order by user_name";
    $query_result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_row($query_result)) {
      echo '<form method="POST" action="otherprofiles.php">
      <label for="name">Moderátor</label><br>
      <input type="hidden" name="name" value='.$row[0].'>
      <input type="submit" value='.$row[0].'>
        </form>';
    }
    $query = "SELECT user_name from users where user_name != '" . $_SESSION['user_name'] . "' and moderator=0 and admin=0 order by user_name";
    $query_result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_row($query_result)) {
      echo '<form method="POST" action="otherprofiles.php">
      <label for="name">User</label><br>
      <input type="hidden" name="name" value='.$row[0].'>
      <input type="submit" value='.$row[0].'>
        </form>';
    }
        ?>
    </main>
    <footer id="footer" class="unselectable">
      <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
  </footer>
</body>
</html>