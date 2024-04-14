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
<header>
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
        <a class="inactive_dropdown" href="profiles.php">Saját profil</a>
        <a class="inactive_dropdown" href="refresh_others_page.php">Adatok módosítása</a>
        <a class="inactive_dropdown" href="refresh_pwd_page.php">Jelszó módosítása</a>
		<a class="active_dropdown" href="myforms.php">Beküldött űrlapjaid</a>
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
    <?php
    if(isset($_SESSION["user_name"])) {
      echo '<header id="form_1">
      <div class="text1">
          <h1>Beküldött űrlapjaid</h1>
      </div>
    </header>';
    } ?>
    <main class="torzs table_div">
    <?php
    $query = "SELECT lok_name from forms where sajatid = '" . $_SESSION['id'] . "'";
		include("connection.php");
		$query_result = mysqli_query($con, $query);
        $test=mysqli_fetch_row($query_result);
        if (empty($test)) {
            echo '<div class="text1">
                <h1>Egy űrlapot sem küldtél be.</h1>
            </div>';
        }
        else {
        //Adatok táblázatba írása. Menő, mi?
        echo '<table>
        <thead>
            <tr>
                <th class="table_header">Mozdony neve</th>
                <th class="table_header">Hajtás típusa</th>
                <th class="table_header">Miért kedvenc</th>
            </tr>
        </thead>
        <tbody>';
        $query = "SELECT lok_name from forms where sajatid = '" . $_SESSION['id'] . "'";
        $query_result = mysqli_query($con, $query);
		while ($row = mysqli_fetch_row($query_result)) {
		    echo '<tr>';
            echo '<th class="table_odd">'.$row[0].'</th>';
            $query = "SELECT lok_type from forms where lok_name = " .'"'. $row[0].'"'. " and sajatid = '".$_SESSION['id']."'";
            $query_result1=mysqli_query($con, $query);
            $row1 = mysqli_fetch_row($query_result1);
            echo '<th class="table_even">'.$row1[0].'</th>';
            $query1 = "SELECT lok_reason from forms where lok_name = " .'"'. $row[0].'"'. " and sajatid = '".$_SESSION['id']."'";
            $query_result2=mysqli_query($con, $query1);
            $row2 = mysqli_fetch_row($query_result2);
            echo '<th class="table_odd">'.$row2[0].'</th>';
            echo ' </tr>';
		    }
        echo '</table>';
        }
        ?>
    </main>
    <footer id="footer" class="unselectable">
      <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
  </footer>
</body>
      </html>