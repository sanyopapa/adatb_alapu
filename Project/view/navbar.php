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
  <link rel="stylesheet" href="styles/navbar.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styles/dropdown.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styles/animation.css?v=<?php echo time(); ?>">
  <link rel="icon" href="img/150_tablogo.png?v=<?php echo time(); ?>">
  <title>R150 Családfa - Főoldal</title>
</head>
<body>  
  <nav class="navbar">
    <button class="navbar-gomb inactive-navbar-button" onclick="location.href= 'fooldal.php'">Főoldal</button>

    <button class="navbar-gomb" onclick="location.href= 'contact.php'">Névjegy</button>
    <?php
      if(isset($_SESSION["user_name"])){
        echo '
      
      <div class="dropgomb">
      <button class="navbar-gomb">Funkciók</button>
      <div class="dropdown">
        <a class="inactive_dropdown" href="">Jegyvásárlás</a>
        <a class="inactive_dropdown" href="berletvasarlas.php">Bérletvásárlás</a>
        <a class="inactive_dropdown" href="refresh_pwd_page.php">Jelszó módosítása</a>
        ';
        if ($_SESSION["admin"] == 1) {
          echo '<a class="inactive_dropdown" href="profilesearch.php">Admin funkciók</a>';
        }
        echo '
      </div>
    </div>
    <button class="navbar-gomb" onclick="location.href='."'../controller/logout.php'".'">Kijelentkezés</button>';
      }
      else {
        echo '<button class="navbar-gomb" onclick="location.href= '."'login_page.php'".'">Bejelentkezés</button>';
      }
    ?>
    <div>
      <img class="profile_pic" src="../img/150_white_logo.png" alt="Fenti logó">
    </div>
  </nav>
</body>