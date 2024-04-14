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
    <link rel="icon" href="img/150_tablogo.png">
    <title>R150 Samu</title>
</head>
<body>
    <nav class="navbar">
        <button class="navbar-gomb" onclick="location.href= 'index.php'">Főoldal</button>
        <button class="navbar-gomb" onclick="location.href= 'about.php'">Rólunk</button>
        <div class="dropgomb">
          <button class="navbar-gomb active-navbar-button">Vonatok</button>
          <div class="dropdown">
            <a class="active_dropdown" href="samu.php">Samu</a>
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
        <div>
          <img class="profile_pic" src="img/150_white_logo.png" alt="Fenti logó">
        </div>
      </nav>

    <header class="container">
        <div class="image">
            <img class="index_pic" src="img/samu_rajz.png" alt="Rajz a vonatról">
        </div>
        <div class="text1 ">
            <h1>A Samu (MÁV BVmot, ma H-START 434 sorozat)</h1>
        </div>
    </header>
    <main class="torzs">
        <p>
            <strong>A Samu a MÁV egyik legkülönlegesebb vonatszerelvénye. Nem csak a színvilága, hanem az eredeti felhasználása, a képességei és a darabszáma miatt is. Ismerjük meg közelebbről!</strong> 
        </p>
        <p>
            A BVmot-ot a Ganz-Hunslet gyártotta. Ez a cég a széles körben ismert Ganz-MÁVAG egyik utódvállalata, angol tulajdonossal. Mindössze 3 darab szerelvény készült 1994-ben. A motorvonat 1 db úgynevezett másodosztályú motorkocsiból, 1-1 db első- és másodosztályú betétkocsiból, illetve egy másodosztályú vezérlőkocsiból állt. A betétkocsik érdekessége, hogy mennyiségük változtatható: Ki is sorozhatóak és akár egy normál, mozdonyvontatású szerelvényben is tudnak működni. Egy motorkocsi maximum 5 kocsit tud fűteni (1 vezérlő és 4 betét), így a kocsik mennyisége ily módon korlátozva van. A pontos technikai adatokat egy táblázatban összeszedtem.
        </p>
        <p>
            A becenevének története igen érdekes: A MÁV-nak 1945-1950 között az elnökét Varga Lászlónak hívták. A motorvonatok a készülésükkor nevet kaptak, melyet a mai napig megtalálhatunk rajtuk egy táblán. Az első szerelvény a "Varga László" nevet kapta. Akkoriban dolgozott egy Varga László nevű ember ott és neki a beceneve Samu volt. Innen jött a motorvonatok neve.
        </p>
        <p>
            Az első éveiben Szegedre közlekedtek Intercity vonatként. Ez után megfordultak, többek között kör-IC-n <em>(Budapest-Nyugati - Debrecen - Nyíregyháza - Miskolc-Tiszai - Budapest-Keleti)</em>, Eger felé és Somogyországban. Nyaranta látogatták a Balaton déli partját is. A motorvonatokról tudni illik, hogy "hisztis" természetűek: Elég bonyolult szerkezetűre sikeredtek, így sokszor álltak/állnak, nem megbízhatóak. Emiatt a 2010-es években fele a 150-es vonalon (mely jelenleg felújítás alatt áll) közlekedtek. 2022 óta a 71-es vonalon (Budapest-Nyugati - Veresegyház - Vác) jár egy szerelvény. A MÁV 2022-ben a nyári retro hétvégén is közlekedtette a jelenlegi egy üzemképes Samu szerelvényt, a jövőben várható ilyen jellegű felbukkanása is a magyar síneken.
        </p>
        
    </main>
    <div class="torzs">
        <div class="body_image_to_center"><img class="img_float_left" src="img/Samu_pic.jpg" alt="Samu halad be Kiskunhalasra"></div>
        <p>Samu halad be Kiskunhalasra 2020. februárjában</p>
        <p>Videó: </p>
        <video controls id="video">
            <source src="videos/video.mp4" type="video/mp4">
            Samu halad ki Kiskunhalasról.
          </video>
    </div>
    <footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
</body>
</html>