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
    <title>R150 Pupos</title>
</head>
<body>

  <nav class="navbar">
    <button class="navbar-gomb" onclick="location.href= 'index.php'">Főoldal</button>
    <button class="navbar-gomb" onclick="location.href= 'about.php'">Rólunk</button>
    <div class="dropgomb">
      <button class="navbar-gomb active-navbar-button">Vonatok</button>
      <div class="dropdown">
        <a class="inactive_dropdown" href="samu.php">Samu</a>
        <a class="active_dropdown" href="pupos.php">Púpos</a>           
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
            <img class="index_pic" src="img/Pupos_rajz.png" alt="Rajz a vonatról">
        </div>
        <div class="text1 ">
            <h1>A Púpos (MÁV M40, ma H-START 408 sorozat)</h1>
        </div>
      </header>
    <main class="torzs">
        <p><strong>A Púpos Magyzarország második kedvenc mozdonya - legalábbis az Indóház magazin szerkesztői szerint. A magyar gyártmányú, jellegzetes alakú dízelgép Magyarország-szerte sok helyen szolgáltak, köztük a napfény városában, Szegeden is. (1967-1982 között) Nézzük meg őket közelebbről!</strong> </p>
        
        <p>A hazai vasúti közlekedésben az 1950-es évek végétől előtérbe került a gőzvontatásról a korszerűbb dízelvontatásra való áttérés. Ehhez szükség volt új dízelmozdonyok beszerzésére. </p>
        
        <p> A dízelesítési program keretében már 1960-ban megkezdődtek az új mozdonytípus tervezési munkálatai, melyet 1963-ban két prototípus, a DVM6 elkészítése követett. A prototípusok tesztelése alatt szerzett tapasztalatok figyelembevételével kidolgozott típus sorozatgyártása 1966-ban kezdődött, 7 darab normál nyomtávú (DVM8-1 vagy DVM8 A) és 3 darab széles nyomtávú változat (DVM8-2 vagy DVM8 B) legyártásával - utóbbiak Záhonyban teljesítettek szolgálatot. 1967-ben az előző évben legyártott mozdonyokhoz képest apróbb változtatásokkal további 25 normál - és 5 széles nyomtávú példány készült, ezek voltak a DVM8-3 és DVM8-4 jelzésű gépek. A típus utolsó sorozatában 1968 és 1970 között 40 darab mozdony készült el, a DVM8-5, -6 és -7 típusjelekkel; az alváltozatok között apró különbségek voltak. Ezek képesek voltak a többes vezérlésre (egy vezetőfülkéből 2 mozdony működtetése).</p>
        
        <p>Az M40 001 és 002-es mozdonyok a Ganz-MÁVAG DVM6-1 jellegű konstrukcióhoz tartoztak. Gyári pályaszámuk DVM6-1-198 és DVM6-1-199. A mozdonyok az M40 001 és 002-es pályaszámokat csak a próbafutások során viselték, mivel a MÁV később nem vette át a mozdonyokat. Ezért a gyártó 1969-ben eladta azokat a Diósgyőri Kohászati Műveknek. Ott az A27 001 és 002 pályaszámokat kapták meg. 1989-ben selejtezték őket.</p>
        
        <p>A mozdony igen jó konstrukciónak számított, a maga korában több tekintetben is a világszínvonalat képviselte, olyannyira, hogy módosított változatai külföldön is vevőre találtak <em>(DVM9: Kuba, DVM11: Egyiptom)</em>. Mivel az eltérő időben épült, eltérő műszaki adottságokkal rendelkező járművek karbantartása nem volt hatékonyan megoldható, az 1970-es évektől a mozdonyok egyes részeit átépítették, annak érdekében, hogy a fenntartásuk egyszerűbben legyen megoldható.</p>
        <p>Az 1980-as években a villamos vontatás térhódítása, valamint az 1990-es években a szállítási igények csökkenése következtében az M40-es mozdonyok alkalmazási területe jelentősen csökkent. 1992-ben kezdődött a sorozat fokozatos selejtezése. Jelenleg 6 darab van a MÁV-START állományban Záhony és Hatvan járműbiztosítási központjaiban. 2 példány a GYSEV-nél, 2 mozdony az MRT (korábban: MÁV Nosztalgia) flottáját erősíti. Működő Púposokat leggyakrabban Záhony és Hatvan térségében látni.</p>
    </main>
    <div class="torzs">
      <div class="body_image_to_center"><img class="img_float_right demo" src="img/pupos_pic.jpg" alt="Púpos Kiskunhalason"></div>
        <p>Egy (azóta nem közlekedő) Púpos pihen Kiskunhalason gyomirtó vonattal.</p>
        <p>Videó: </p>
        <video controls id="video">
          <source src="videos/video.mp4" type="video/mp4">
            Púpos halad ki gyomirtó vonattal Kiskunhalasról
        </video>
    </div>
    <footer id="footer" class="unselectable">
      <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
  </footer>
</body>
</html>