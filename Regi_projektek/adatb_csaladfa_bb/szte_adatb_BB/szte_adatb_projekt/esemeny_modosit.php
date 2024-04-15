<?php
	if(!isset($_SESSION)){session_start();}
  $date_error="";
  $same_error="";
  $foglalt="";
  if(isset($_SESSION["message"])){
		$keys = array_keys($_SESSION["message"]);
		for($i=0; $i < count($_SESSION["message"]); $i++) {
			
			if ($keys[$i] == 'same') {
				$same_error .= $_SESSION["message"][$keys[$i]] . ' ';
			}
			if ($keys[$i] == 'date') {
				$date_error .= $_SESSION["message"][$keys[$i]] . ' ';
			}
      if ($keys[$i] == 'foglalt') {
				$foglalt .= $_SESSION["message"][$keys[$i]] . ' ';
			}
		}
				unset($_SESSION["message"]);
	} 
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
    <title>R150 Családfa - Esemény módosítása</title>
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
        <a class="inactive_dropdown" href="szemely_modosit.php">Személy módosítása</a>
        <a class="inactive_dropdown" href="esemeny_letrehoz.php">Esemény hozzáadása</a>
        <a class="active_dropdown" href="esemeny_modosit.php">Esemény módosítása</a>
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
    <?php
    if(isset($_SESSION["user_name"])) {
      echo '
      <main class="torzs">
      <div class="text1">
          <h1>Esemény módosítása </h1>
      </div>
      <div class="anti-collapse"></div>';
  if ($_SESSION['akt_csaladnev']=="") {
    echo '<p>Válassz ki egy családot!</p>';

  }
  else {
    echo '<form method="POST" action="esemeny_check_modosit.php">
      <fieldset class="form_2">
        <legend>Esemény adatai:</legend>';
        include("connection.php");
        $tabla_neve_e=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_esemenyek';
        $tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_szemelyek';
        $query="SELECT id, szemelyid, hazassag_datum, valas_datum, erintett_id from $tabla_neve_e";
        $query_result=mysqli_query($con, $query);
        if (mysqli_num_rows($query_result)==0) {
          header("location: esemeny_letrehoz.php");
        }
        else 
        if(strlen($same_error)> 0){
          echo '<div class="warning">';
          echo $same_error;
          echo "</div>";
        }
        if(strlen($date_error)> 0){
          echo '<div class="warning">';
          echo $date_error;
          echo "</div>";
        }
        if(strlen($foglalt)> 0){
          echo '<div class="warning">';
          echo $foglalt;
          echo "</div>";
        } {
          echo '
          <label for="letezo_szemely">Válaszd ki az eseményt!</label>
          <select id="select", name="letezo_esemeny">
          <option value=""></option>';
          while ($rows=mysqli_fetch_row($query_result)) {
            $query_e="SELECT nev from $tabla_neve where id=".$rows[1];
            $query_result_e = mysqli_query($con, $query_e);
            $row_e=mysqli_fetch_row($query_result_e);
            $query_m="SELECT nev from $tabla_neve where id=".$rows[4];
            $query_result_m = mysqli_query($con, $query_m);
            $row_m=mysqli_fetch_row($query_result_m);
            echo '
            <option value="'.$rows[0].'">'.$row_e[0].' ekkor: '.$rows[2].' vele: '.$row_m[0].'</option>';
          }
          echo '</select><br>';
          $query="SELECT id, nev from $tabla_neve";
          $query_result=mysqli_query($con, $query);
          echo '
          <label for="letezo_szemely">Válaszd ki az egyik személyt!</label>
          <select id="select", name="egyik_szemely">
          <option value=""></option>';
          while ($rows=mysqli_fetch_row($query_result)) {
            echo '
            <option value="'.$rows[0].'">'.$rows[1].'</option>';
          }
          echo '</select><br>';
          $query_result=mysqli_query($con, $query);
          echo '
          <label for="letezo_szemely">Válaszd ki a másik személyt!</label>
          <select id="select", name="masik_szemely">
          <option value=""></option>';
          while ($rows=mysqli_fetch_row($query_result)) {
            echo '
            <option value="'.$rows[0].'">'.$rows[1].'</option>';
          }
          echo '</select><br>';
        
        }
        echo '
        <label for="birth">Házasság dátuma:</label>
        <input type="date" class="birth" name="hazassag" placeholder=""/> <br>
        <label for="birth">Válás dátuma:</label>
        <input type="date" class="birth" name="valas" placeholder=""/> <br>
        <input type="submit"><br>
        <input type="reset">
      </fieldset>
      <br>
    </form>


  </main>';
    }
    
  }
    else {
      header('location: login_page.php');
    }
   ?>
   <footer id="footer" class="unselectable">
    <p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p> 
</footer>
    
    
   
</body>
  </html>

