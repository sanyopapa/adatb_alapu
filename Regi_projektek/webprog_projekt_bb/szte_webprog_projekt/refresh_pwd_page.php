<?php
	if(!isset($_SESSION)){session_start();}
	
	
	$user_name_error = "";
	$pwd_error = "";
	$pwd_2_error = "";
	$email_error = "";
	if(isset($_SESSION["message"])){
		$keys = array_keys($_SESSION["message"]);
		for($i=0; $i < count($_SESSION["message"]); $i++) {
			
			if ($keys[$i] == 'user_name') {
				$user_name_error .= $_SESSION["message"][$keys[$i]] . ' ';
			}
			if ($keys[$i] == 'pwd') {
				$pwd_error .= $_SESSION["message"][$keys[$i]] . ' ';
			}
			if ($keys[$i] == 'pwd_2') {
				$pwd_2_error .= $_SESSION["message"][$keys[$i]] . ' ';
			}
			
		}
		
		// After we got the message, set it to null, so it doesn't linger in the system indefinitely.
		unset($_SESSION["message"]);
	} 
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <title>R150 - Dolgaid</title>
</head>
<body>
<header>
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
        echo '<div class="dropgomb">
      <button class="navbar-gomb active-navbar-button">Dolgaid</button>
      <div class="dropdown">
        <a class="inactive_dropdown" href="myprofile.php">Saját profil</a>
        <a class="inactive_dropdown" href="refresh_others_page.php">Adatok módosítása</a>
        <a class="active_dropdown" href="refresh_pwd_page.php">Jelszó módosítása</a>
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
</header>
<main class="torzs">
<div class="anti-collapse"></div>

<div class="form-box">
        <form id="form-login" action="refresh_pwd_check.php" method="POST">
            <fieldset class="form_2">
                <legend>Jelszó módosítása</legend>
                <?php 
                    if(strlen($pwd_error)>0){
                        echo '<div class="warning">';
                        echo $pwd_error;
                        echo "</div>";
                    } 
                ?>
                <label for="pwd">Régi jelszó:</label>
                <input type="password" id="pwd" name="pwd" required>
                <br>
                <?php 
                    if(strlen($pwd_error)>0){
                        echo '<div class="warning">';
                        echo $pwd_error;
                        echo "</div>";
                    } 
                ?>
                
                <label for="new_pwd">Jelszó:</label>
                <input type="password" id="new_pwd" name="new_pwd" required>
                <br>
                
                <?php 
                    if(strlen($pwd_2_error)>0){
                        echo '<div class="warning">';
                        echo $pwd_2_error;
                        echo "</div>";
                    } 
                ?>
                
                <label for="new_pwd_2">Jelszó újra:</label>
                <input type="password" id="new_pwd_2" name="new_pwd_2" required>
                <br>
                <input type="reset" name="btn-reset" value="Törlés">
                <input type="submit" name="btn-submit"  value="Küldés">
            </fieldset>
        </form>
    </div>
</main>    
<footer id="footer" class="unselectable">
      <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
  </footer>
</body>
</html>