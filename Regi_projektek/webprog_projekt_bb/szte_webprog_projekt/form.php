<?php
	if(!isset($_SESSION)){session_start();}
?>
<!DOCTYPE html>
<html lang="hu">
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
    <title>R150 Form</title>
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
        echo '<div class="dropgomb">
      <button class="navbar-gomb active-navbar-button">Dolgaid</button>
      <div class="dropdown">
        <a class="inactive_dropdown" href="myprofile.php">Saját profil</a>
        <a class="inactive_dropdown" href="refresh_others_page.php">Adatok módosítása</a>
        <a class="inactive_dropdown" href="refresh_pwd_page.php">Jelszó módosítása</a>
		<a class="inactive_dropdown" href="myforms.php">Beküldött űrlapjaid</a>
		<a class="inactive_dropdown" href="message/message_page.php">Beszélgetések</a>
    <a class="inactive_dropdown" href="profilesearch.php">Profilok</a>
    <a class="inactive_dropdown" href="logout.php">Kijelentkezés</a>
      </div>
    </div>';
        echo '<button class="navbar-gomb active-navbar-button" onclick="location.href= '."'form.php'".'">Űrlap</button>';
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
          <h1>Űrlap a kedvenc vonatodról</h1>
      </div>
  </header>
  <main class="torzs">
    <form method="POST" action="form_check.php">
      <fieldset class="form_2">
        <legend>Kedvenc mozdonyod: </legend>
        <label>'.$form_success.'</label>
        <label>Mozdony neve: <input type="text" name="lok_name" required></label><br><br>
        Mozdony hajtása:<br>
        <label for="mode">Dízeles</label>
        <input type="radio" id="mode-1" name="lok_type" value="Dízel"/><br>
        <label for="mode">Elektromos</label>
        <input type="radio" id="mode-2" name="lok_type" value="Elektromos"/><br>
        <label for="mode">Egyéb</label>
        <input type="radio" id="mode-3" name="lok_type" value="Egyéb" checked/> <br><br>
        <label for"lok_reason">Miért ez a kedvenced?</label><br>
        <textarea name="lok_reason" rows="5" cols="30" maxlength="200"
        placeholder="Ide írd a válaszod"></textarea> <br><br>
        <input type="submit"/>
        <input type="reset">
      </fieldset>
    </form>
  </main>';
    }
    else {
      header('location: login_page.php');
    }
    ?>
    
    
    <footer id="footer" class="unselectable">
      <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
</body>