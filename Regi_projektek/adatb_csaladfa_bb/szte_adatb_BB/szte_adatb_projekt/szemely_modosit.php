<?php
	if(!isset($_SESSION)){session_start();}
  $date_error="";
  if(isset($_SESSION["message"])){
		$keys = array_keys($_SESSION["message"]);
		for($i=0; $i < count($_SESSION["message"]); $i++) {
			
			if ($keys[$i] == 'date') {
				$date .= $_SESSION["message"][$keys[$i]] . ' ';
			}
		}
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
  <title>R150 Családfa - Személy hozzáadása</title>
</head>
<body>
<header>
<nav class="navbar">
    <button class="navbar-gomb" onclick="location.href= 'index.php'">Főoldal</button>
    <button class="navbar-gomb" onclick="location.href= 'contact.php'">Névjegy</button>
    <?php
      if(isset($_SESSION["user_name"])){
        echo '
      
      <div class="dropgomb">
      <button class="navbar-gomb active-navbar-button">Funkciók</button>
      <div class="dropdown">
        <a class="inactive_dropdown" href="myprofile.php">Rögzített adatok</a>
        <a class="inactive_dropdown" href="szemely_letrehoz.php">Személy hozzáadása</a>
        <a class="active_dropdown" href="szemely_modosit.php">Személy módosítása</a>
        <a class="inactive_dropdown" href="esemeny_letrehoz.php">Esemény hozzáadása</a>
        <a class="inactive_dropdown" href="esemeny_modosit.php">Esemény módosítása</a>
        <a class="inactive_dropdown" href="tasks.php">Feladatokra vonatkozó megoldás</a>
        <a class="inactive_dropdown" href="refresh_pwd_page.php">Jelszó módosítása</a>
      </div>
    </div>
    <button class="navbar-gomb" onclick="location.href='."'logout.php'".'">Kijelentkezés</button>';
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
<div class="text1">
          <h1>Személy módosítása</h1>
      </div>
  <div class="anti-collapse"></div>
  <?php 
  if ($_SESSION['akt_csaladnev']==""){
    echo '<p>Válassz ki egy családot!</p>';
  }
  else {

  
  echo '   
    <form id="form-login" class="login-link" action="szemely_check_modosit.php" method="POST">
      <fieldset class="form_2">
          <legend>Személy adatai:</legend>';
           
          $tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_szemelyek';
          $query="SELECT id, nev from $tabla_neve";
          include("connection.php");
          $query_result=mysqli_query($con, $query);
          if(strlen($date_error)> 0){
            echo '<div class="warning">';
            echo $date;
            echo "</div>";
          }
          if (mysqli_num_rows($query_result) == 0) {header("location: szemely_letrehoz.php");}
          else {
            echo '
            <label for="letezo_szemely">Válaszd ki a személyt!</label>
            <select id="select", name="letezo_szemely">
            <option value=""></option>';
            while ($rows=mysqli_fetch_row($query_result)) {
              echo '
              <option value="'.$rows[0].'">'.$rows[1].'</option>';
            }
            echo '</select><br>';
          }
          echo '
          <label for="nem">Nem:</label>
          <select id="select" name="nem" >
          <option name="nem" value="ferfi">Férfi</option>
          <option name="nem" value="no">Nő</option>
          <option name="nem" value="n/a" selected>Nem meghatározható</option>
          </select><br>';
          echo '<label for="birth">Születési dátum: </label>';
          echo '<input type="date" class="birth" name="szuletes" placeholder="" > <br>';
          echo '<label for="birth">Halálozási dátum: </label>';
          echo '<input type="date" class="birth" name="halal" placeholder=""/> <br>';
          echo '<label for="user-name">Anyja neve: </label>';
          echo '<input type="text" id="user-name" name="anyja_neve" size="25" placeholder="" ><br>';
          echo '<label for="user-name">Apja neve: </label>';
          echo '<input type="text" id="user-name" name="apja_neve" size="25" placeholder="" ><br>';
          echo ' <label for="introduction">Testvérek felsorolva<br>(max. 200 karakter):</label> <br/>
          <textarea id="intro" name="testverek" rows="5" cols="30" maxlength="200" 
          placeholder="A neveket vesszővel válaszd el, szóköz ne legyen!"></textarea> <br/>
          <input type="reset" name="btn-reset" value="Törlés"><br>
          <input type="submit" name="btn-submit"  value="Küldés">
      </fieldset>
      <br>
    </form>';
          
        }?>
          
          

</main>    
<footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
</body>
</html>
