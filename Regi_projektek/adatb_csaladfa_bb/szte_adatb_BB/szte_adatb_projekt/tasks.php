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
  <title>R150 Családfa - Főoldal</title>
</head>
<body>  
  <nav class="navbar">
    <button class="navbar-gomb" onclick="location.href= 'index.php'">Főoldal</button>
    <button class="navbar-gomb" onclick="location.href= 'contact.php'">Névjegy</button>
    <?php
      if(isset($_SESSION["user_name"])){
        echo '
      <div class="dropgomb">
      <button class="navbar-gomb active-navbar-button">Funkciók</button>
      <div class="dropdown">
      <div class="dropdown">
      <a class="inactive_dropdown" href="myprofile.php">Rögzített adatok</a>
      <a class="inactive_dropdown" href="szemely_letrehoz.php">Személy hozzáadása</a>
      <a class="inactive_dropdown" href="szemely_modosit.php">Személy módosítása</a>
      <a class="inactive_dropdown" href="esemeny_letrehoz.php">Esemény hozzáadása</a>
      <a class="inactive_dropdown" href="esemeny_modosit.php">Esemény módosítása</a>
      <a class="active_dropdown" href="tasks.php">Feladatokra vonatkozó megoldás</a>
      <a class="inactive_dropdown" href="refresh_pwd_page.php">Jelszó módosítása</a>
    </div>
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
  <div class="text1 ">
            <h1>Az előre kitűzött feladatok megoldása:</h1>
        </div>
    <main class="torzs">
    <?php 
    if (empty($_SESSION['akt_csaladnev'])) {
      echo '<p>Állíts be családot!</p>';
  }
  else {
    echo'
    <form method="POST" action="task_check.php">
    <fieldset class="form_2">
    <legend>Az első feladathoz mező (az eredmény közvetlen ez alatt fog megjelenni)</legend>
    <label for="birth">Kilistázza táblázatos formában az adott családfához tartozó összes eseményt egy a felhasználó által megadott idő intervallumon belül.</label>
    <label for="birth">Mettől?</label>
        <input type="date" class="birth" name="tol" placeholder=""/ required> <br>
        <label for="birth">Meddig?</label>
        <input type="date" class="birth" name="ig" placeholder=""/ required> <br>
        <input type="submit"><br>
        <input type="reset">
    </fieldset>
    </form>';
    if (array_key_exists('tol', $_SESSION) and array_key_exists('ig', $_SESSION)){
      $tol=$_SESSION["tol"];
      $ig=$_SESSION["ig"];
    }
    unset($_SESSION["tol"]);
    unset($_SESSION["ig"]);
    include("connection.php");
    if (!empty($tol) and !empty($ig) and !empty($_SESSION["akt_csaladnev"])) {
      $tabla_neve_e=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_esemenyek';
      $tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_szemelyek';
      $query="SELECT e.id, p1.nev AS egyik_szemely_neve, p2.nev AS masik_szemely_neve, e.hazassag_datum
      FROM $tabla_neve_e AS e
      JOIN $tabla_neve AS p1 ON e.szemelyid = p1.id
      JOIN $tabla_neve AS p2 ON erintett_id = p2.id
      WHERE e.hazassag_datum >= ? AND e.hazassag_datum <= ? ";
      $stmt=mysqli_prepare($con, $query);
      mysqli_stmt_bind_param($stmt, "ss", $tol, $ig);
      $siker=mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
			mysqli_stmt_bind_result($stmt, $id, $egyik_szemely, $masik_szemely, $hazassag);
        //$query_result = mysqli_query($con, $query);
        if (mysqli_stmt_num_rows($stmt)==0) {
          echo '<p>Jelenleg nincs egy házassága sem a kért családnak</p>';
        }
        else {
          echo '
          <table>
          <thead>
            <tr>
            <th class="table_header" colspan="5">'.$_SESSION["akt_csaladnev"].' család Házasságai:</th>
            </tr>
            <tr>
              <th class="table_header">Egyik érintett neve</th>
              <th class="table_header">Másik érintett neve</th>
              <th class="table_header">Házasság dátuma</th>
            </tr>
          </thead>
          <tbody>';
          while (mysqli_stmt_fetch($stmt)) {
            echo '<tr>
              <th class="table_odd">'.$egyik_szemely.'</th>
              <th class="table_odd">'.$masik_szemely.'</th>
              <th class="table_odd">'.$hazassag.'</th>';
                echo '
              </th>
            </tr>';
          }
          echo '</tbody>';
        }
        echo '</table><br>';

        $query="SELECT e.id, p1.nev AS egyik_szemely_neve, p2.nev AS masik_szemely_neve, e.valas_datum
        FROM $tabla_neve_e AS e
        JOIN $tabla_neve AS p1 ON e.szemelyid = p1.id
        JOIN $tabla_neve AS p2 ON erintett_id = p2.id
        WHERE e.valas_datum >= ? AND e.valas_datum <= ? ";
        $stmt=mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "ss", $tol, $ig);
        $siker=mysqli_stmt_execute($stmt); 
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $id, $egyik_szemely, $masik_szemely, $valas);
        if (mysqli_stmt_num_rows($stmt)==0) {
          echo '<p>Jelenleg nincs egy válása sem a kért családnak</p>';
        }
        else {
          echo '
          <table>
          <thead>
            <tr>
            <th class="table_header" colspan="5">'.$_SESSION["akt_csaladnev"].' család válásai:</th>
            </tr>
            <tr>
              <th class="table_header">Egyik érintett neve</th>
              <th class="table_header">Másik érintett neve</th>
              <th class="table_header">Válás dátuma</th>

            </tr>
          </thead>
          <tbody>';
          while (mysqli_stmt_fetch($stmt)) {
            echo '<tr>
              <th class="table_odd">'.$egyik_szemely.'</th>
              <th class="table_odd">'.$masik_szemely.'</th>
              <th class="table_odd">'.$valas.'</th>';
                echo '
              </th>
            </tr>';
          }
          echo '</tbody>';
        }
        echo '</table><br>';
      
    }
    $tabla_neve=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_szemelyek';
    $tabla_neve_e=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_esemenyek';
    $query="SELECT nev, szuletes, YEAR(CURDATE()) - YEAR(szuletes) AS eletkor
    FROM $tabla_neve
    WHERE halalozas=0
    ORDER BY eletkor DESC";
      $query_result = mysqli_query($con, $query);
      if (mysqli_num_rows($query_result)==0) {
        echo '<p>Jelenleg nincs egy élő tagja sem a kért családnak</p>';
      }
      else {
        echo '
        <table>
        <thead>
          <tr>
          <th class="table_header" colspan="5">'.$_SESSION["akt_csaladnev"].' család élő tagjai:</th>
          </tr>
          <tr>
            <th class="table_header">Személy neve:</th>
            <th class="table_header">Születési dátum:</th>
            <th class="table_header">Életkor:</th>
          </tr>
        </thead>
        <tbody>';
        while ($rows = mysqli_fetch_row($query_result)) {
          
          echo '<tr>
            <th class="table_odd">'.$rows[0].'</th>
            <th class="table_odd">'.$rows[1].'</th>
            <th class="table_odd">'.$rows[2].'</th>';
              echo '</form>
            </th>
          </tr>';
        }
        echo '</tbody>';
      }
      echo '</table><br>';
      $query="SELECT szemelyid, erintett_id, MIN(DATEDIFF(valas_datum, hazassag_datum)) AS rovidebb_ido
      FROM $tabla_neve_e
      WHERE valas_datum !=0";
      $query="SELECT p1.nev AS egyik_szemely_neve, p2.nev AS masik_szemely_neve
      FROM $tabla_neve_e AS e
      JOIN $tabla_neve AS p1 ON e.szemelyid = p1.id
      JOIN $tabla_neve AS p2 ON erintett_id = p2.id
      WHERE e.valas_datum IS NOT NULL
      ORDER BY DATEDIFF(e.valas_datum, e.hazassag_datum) ASC
      LIMIT 1";
      $query_result = mysqli_query($con, $query);
      if (mysqli_num_rows($query_result)== 0) {
        echo '<p>Jelenleg a kért családnak minden párja együtt van</p>';
      }
      else {
        $rows=mysqli_fetch_row($query_result);  
        echo '<p>A legrövidebb ideig tartó házasság '.$rows[0].' és '.$rows[1].' között volt.</p>';
      }
      $query="SELECT p1.nev AS egyik_szemely_neve, 
      p2.nev AS masik_szemely_neve, 
      YEAR(e.hazassag_datum) AS hazassag_eve, 
      ABS(YEAR(p1.szuletes) - YEAR(p2.szuletes)) AS korkulonbseg
      FROM uj_eszti_esemenyek AS e
      JOIN uj_eszti_szemelyek AS p1 ON e.szemelyid = p1.id
      JOIN uj_eszti_szemelyek AS p2 ON e.erintett_id = p2.id";
      $query_result = mysqli_query($con, $query);
      if (mysqli_num_rows($query_result)== 0) {
        echo '<p>Jelenleg a kért családban egy házasság sem köttetett.</p>';
      }
      else {
        echo '
        <table>
        <thead>
          <tr>
          <th class="table_header" colspan="5">'.$_SESSION["akt_csaladnev"].' család házasságai:</th>
          <tr>
          <th class="table_header">Házasság éve:</th>	
          <th class="table_header">Egyik érintett neve:</th>
            <th class="table_header">Másik érintett neve:</th>
            <th class="table_header">Korkülönbség:</th>
          </tr>
        </thead>
        <tbody>';
        while ($rows=mysqli_fetch_row($query_result)) {
          echo '<tr>
          <th class="table_odd">'.$rows[2].'</th>	
          <th class="table_odd">'.$rows[0].'</th>
            <th class="table_odd">'.$rows[1].'</th>
            <th class="table_odd">'.$rows[3].'</th>';
              echo '</form>
            </th>
          </tr>';
        }
        echo '</tbody>';
      }
      echo '</table><br>';
      $tabla_neve_t=$_SESSION["akt_csaladnev"].'_'.$_SESSION["user_name"].'_testverek';
      $query= "SELECT s.nev AS szemely_neve, COALESCE(COUNT(t.szemelyid), 0) AS testverek_szama FROM $tabla_neve AS s LEFT JOIN $tabla_neve_t AS t ON s.id = t.szemelyid WHERE YEAR(CURDATE()) - YEAR(s.szuletes) < 18 GROUP BY s.nev";
      $query_result = mysqli_query($con, $query);
      if (mysqli_num_rows($query_result)== 0) {
        echo '<p>Jelenleg a kért családban nincs 18 évnél fiatalabb tag.</p>';
      }
      else {
        echo '
        <table>
        <thead>
          <tr>
          <th class="table_header" colspan="5">Az '.$_SESSION["akt_csaladnev"].' család 18 évnél fiatalabb tagjai:</th>
          <tr>
          <th class="table_header">Név:</th>	
          <th class="table_header">Testvérek száma:</th>
            
        </thead>
        <tbody>';
        while ($rows=mysqli_fetch_row($query_result)) {
          echo '<tr>
          <th class="table_odd">'.$rows[0].'</th>
            <th class="table_odd">'.$rows[1].'</th>
            </th>
          </tr>';
        }
        echo '</tbody>';
      }
      echo '</table><br>';
    }
   ?>
    </main>
    <footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
</body>
</html>