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
  <!-- <link rel="stylesheet" href="styles/page_content.css?v=<?php echo time(); ?>"> -->
  <link rel="stylesheet" href="styles/navbar.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styles/dropdown.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="styles/animation.css?v=<?php echo time(); ?>">
  <!--<link rel="stylesheet" href="styles/media_size.css?v=<?php echo time(); ?>">
   <link rel="stylesheet" href="styles/footer.css?v=<?php echo time(); ?>"> -->
  <link rel="icon" href="img/150_tablogo.png?v=<?php echo time(); ?>">
  <!-- <link rel="stylesheet" href="styles/form.css?v=<?php echo time(); ?>"> -->
  <title>R150 Családfa - Főoldal</title>
</head>
<body>  
  <nav class="navbar">
    <button class="navbar-gomb inactive-navbar-button" onclick="location.href= 'fooldal.php'">Főoldal</button>
    
    <button class="navbar-gomb" onclick="location.href= 'contact.php'">Névjegy</button>
    <button class="navbar-gomb" onclick="location.href= 'news.php'">Hírek</button>

    <div class="dropgomb">
    <button class="navbar-gomb" >Infók</button>
    <div class="dropdown">
        <a class="inactive_dropdown" href="menetrend.php">Menetrend</a>
        <a class="inactive_dropdown" href="ticket_view.php">Jegyek</a>
        <a class="inactive_dropdown" href="kozerdeku.php">Állomások</a>
        <a class="inactive_dropdown" href="szerelveny.php">Szerelvények</a>

      </div>
    </div>

    <?php
      if(isset($_SESSION["user_name"])){
        echo '
        <button class="navbar-gomb" onclick="location.href='."'myprofile.php'".'">Profil</button>
      <div class="dropgomb">
      <button class="navbar-gomb">Funkciók</button>
      <div class="dropdown">
        <a class="inactive_dropdown" href="ticket.php">Jegyvásárlás</a>
        <a class="inactive_dropdown" href="passes.php">Bérletvásárlás</a>
        <a class="inactive_dropdown" href="osszes_jarat.php">Összes járat egy adott állomásról</a>
        <a class="inactive_dropdown" href="refresh_pwd_page.php">Adataid módosítása</a>
        <a class="inactive_dropdown" href="alacsonypadlos.php">Alacsonypadlós szerelvények</a>
      </div>
    </div>';
    if ($_SESSION["admin"] == 1) {
      echo '<div class="dropgomb">
      <button class="navbar-gomb">Admin funkciók</button>
      <div class="dropdown">
        <a class="inactive_dropdown" href="admin_view.php">Vásárlások megtekintése</a>
        <a class="inactive_dropdown" href="profilesearch.php">Profilok módosítása</a>
        <a class="inactive_dropdown" href="newssearch.php">Hírek módosítása</a>';
 /*        <a class="inactive_dropdown" href="">Szerelvények módosítása</a>
        <a class="inactive_dropdown" href="">Járatok módosítása</a>
        <a class="inactive_dropdown" href="">"Közlekedik" módosítása</a>
        <a class="inactive_dropdown" href="">Jegyek módosítása</a> */
        echo'</div></div>';
    }
    echo '<button class="navbar-gomb" onclick="location.href='."'../controller/logout.php'".'">Kijelentkezés</button>';
      }
      else {
        echo '<button class="navbar-gomb" onclick="location.href= '."'login_page.php'".'">Bejelentkezés</button>';
        echo '<button class="navbar-gomb" onclick="location.href= '."'regist_page.php'".'">Regisztráció</button>';
      }
    ?>
    
    <div>
      <img class="profile_pic" src="../img/150_white_logo.png" alt="Fenti logó">
    </div>
  </nav>
</body>