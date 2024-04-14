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
    <link rel="stylesheet" href="styles/media_size.css">
    <link rel="stylesheet" href="styles/animation.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="icon" href="img/150_tablogo.png">
    <title>R150 About</title>
</head>
<body>
  <nav class="navbar">
    <button class="navbar-gomb" onclick="location.href= 'index.php'">Főoldal</button>
    <button class="navbar-gomb active-navbar-button" onclick="location.href= 'about.php'">Rólunk</button>
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


    <header class="container">
        <div class="image">
            <img class="index_pic logo_img" src="img/150_tablogo.png" alt="Rajz a vonatról">
        </div>
        <div class="text1 ">
            <h1>A történet</h1>
        </div>
      </header>
    <main class="torzs">
        <p><strong>A Railway150 egy 2019-ben indult vasútfotós oldal volt, melynek célja Kiskunhalas vasúti közlekedésének bemutatása volt a szélesebb közösség számára.</strong> </p>

        <div class="body_image_to_center"><img class="img_float_right" src="img/Szergej_1.jpg" alt="Mazsola szállítása 1"></div>

        <p>Ez az egész 2019. április elsején indult. A vonatok iránt már régebb óta érdeklődtem, de erre a vasútfotósdira egy régi barátom vezetett rá, akit Kingának hívnak. Ő a mai napig tevékenykedik ebben és egészen ügyes. A projekt egy Facebook, Youtube és Instagram fiókkal indult, melyből az utóbbit használtam a leggyakrabban. A követők szépen lassan kezdtek gyűlni, jelenleg a Facebook és Instagram oldal több, mint 1100 követőt tudhat magáénak, mely ebben a mezőnyben egészen jó teljesítmény, és ezzel én is meg vagyok elégedve. </p>

        <p>Az oldal megítélése erősen vegyes volt. Akinek nincs kötődése a vasúthoz, esetleg ismert engem, annak tetszett a dolog. Érdekesnek gondolták a "sok, szép, színes" vonatot, amelyeket csak hébe-hóba, esetleg nagyon ritkán vagy soha nem látnak egy vasúti átjárónál történő várakozás alatt. A nagy szakik (akik nem túlzottan tudták lenyelni a jellemem jellegét) nem túlzottan kedveltek. Érkezett kritika a nem szakszerű megközelítés, a képek minősége (tudniillik telefonnal készült az összes képem), illetve a stílusom miatt. Itt nem kezdenék el mindent megmagyarázni, de egy elvet szükségszerűnek érzek megemlíteni: Számomra nagyon fontos a közérthetőség. Nem az a célom, hogy mindenki fel tudja mondani szóról szóra az F.1 utasítást vagy bármilyen szakirodalmat, csak emészthető formában ezt a világot bemutatni.</p>

        <p>2022 egy fontos év volt. Ekkor érettségiztem és ez év február elsejétől állt le a forgalom a 150-es vasútvonalon. Mivel erre a fotózósdira ráuntam, illetve másra kellett az erre fordított idő, így január 31-én lelőttem a projektet. Ezután ugyan készült pár kép (az oldal alján egy ilyen kép található), de napi szinten már nem foglalkozok vele. A célom egy ideje inkább az, hogy ezen alkotások fotóként is megállják a helyüket, ne csak amiatt legyen érdekes, mert vonat van rajta és nem mondjuk egy háziállat vagy a naplemente.</p>

        <p>2023-ban a téma szerteágazósága és érdekessége miatt esett a választás erre, mikor témáról kellett dönteni web tervezés tantárgyból. Az oldalon található képek mind saját alkotások, a Creative Commons 4.0 licenc vonatkozik rájuk. Az alkotásban Kromek Bálint Dániel segített, innen is puszi a pocijára neki. Kettőnk elérhetőségeit <a href="contact.html">ide</a> kattintva elérhetitek.</p>
        <p>Kedvenc vonataim: (A kiemelt vonatok szerepelnek is az oldalon külön.)</p>
        <ul class="list">
          <li>V63 "Gigant"</li>
          <li>M62 "Szergej"</li>
          <li> <a href="pupos.html" class="strong_list"><strong>M40 "Púpos"</strong></a></li>
          <li>1047 "Taurus"</li>
          <li><a href="samu.html" class="strong_list"><strong>BVmot</strong></a>/ BVhmot <a href="samu.html" class="strong_list"><strong>"Samu" </strong></a> és "Kissamu"</li>
        </ul>
        
        <div class="body_image_to_center"><img class="img_float_left" src="img/Szergej_2.jpg" alt="Mazsola szállítása 2"></div>
    </main>

    <footer id="footer" class="unselectable">
      <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
  </footer>
</body>
</html>