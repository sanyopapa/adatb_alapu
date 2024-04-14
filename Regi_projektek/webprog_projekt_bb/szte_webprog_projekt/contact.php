<?php
	if(!isset($_SESSION)){session_start();}
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/page_images.css">
    <link rel="stylesheet" href="styles/page_content.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/dropdown.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/media_size.css">
    <link rel="stylesheet" href="styles/animation.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="icon" href="img/150_tablogo.png">
    <link rel="icon" href="img/150_tablogo.png">
    <title>R150 Contacts</title>
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
        <button class="navbar-gomb active-navbar-button" onclick="location.href= 'contact.html'">Elérhetőségek</button>
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
        echo '<button class="navbar-gomb" onclick="location.href= '."'form.php'".'">Űrlap</button>';
      }
      else {
        echo '<button class="navbar-gomb" onclick="location.href= '."'login_page.php'".'">Bejelentkezés</button>';
      }
    ?>
    <div>
        <div>
          <img class="profile_pic" src="img/150_white_logo.png" alt="Fenti logó">
        </div>
      </nav>

    <header class="container">
        <div class="image">
            <img class="index_pic logo_img" src="img/150_tablogo.png" alt="Rajz a vonatról">
        </div>
        <div class="text1 ">
            <h1>Elérhetőségeink</h1>
        </div>
    </header>
    <main class="torzs table_div">
        
        <table>
            <thead>
                <tr>
                    <th colspan="3" class="table_header">Linkek és egyebek</th>
                </tr>
                <tr>
                    <th class="table_header">Platformok</th>
                    <th class="table_header">Brúnó (R150)</th>
                    <th class="table_header">Dani (DeeAyDan)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="table_odd">Facebook</td>
                    <td class="table_odd"><a class="blue-link" href="https://facebook.com/railway150" target="_blank">Railway150</a></td>
                    <td class="table_odd"></td>
                </tr>
                <tr>
                    <td class="table_even">Instagram</td>
                    <td class="table_even"><a class="blue-link" href="https://instagram.com/railway150" target="_blank">@railway150</a></td>
                    <td class="table_even"></td>
                </tr>
                <tr>
                    <td class="table_odd">Github</td>
                    <td class="table_odd"></td>
                    <td class="table_odd"><a class="blue-link" href="https://github.com/DeeAyDan" target="_blank">DeeAyDan</a></td>
                </tr>
            </tbody>
            </table>
        </main>
    <footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
</body>
</html>