<?php
$name = $_POST['name'];
//echo $name
?>
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
    <title>R150 - Profilok</title>
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
        <a class="inactive_dropdown" href="myprofile.php">Saját profil</a>
        <a class="inactive_dropdown" href="refresh_others_page.php">Adatok módosítása</a>
        <a class="inactive_dropdown" href="refresh_pwd_page.php">Jelszó módosítása</a>
		<a class="inactive_dropdown" href="myforms.php">Beküldött űrlapjaid</a>
		<a class="inactive_dropdown" href="message/message_page.php">Beszélgetések</a>
        <a class="active_dropdown" href="profilesearch.php">Profilok</a>
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
          <h1>'.$name.' adatai:</h1>
      </div>
    </header>';
    } ?>
    <main class="torzs table_div">
    <?php
    $query = "SELECT id from users where user_name = ".'"'.$name.'"';
    
    include("connection.php");
		$query_result = mysqli_query($con, $query);
        $id=mysqli_fetch_row($query_result);
        //Adatok táblázatba írása. Menő, mi?
        echo '<table>
        <thead>
            <tr>
                <th class="table_header"></th>
                <th class="table_header">Adatok</th>
            </tr>
        </thead>
        <tbody>';
        
            echo '<tr>
            <th class="table_odd">Fellhasználónév:</th>
            <th class="table_odd">'.$name.'</th>
            </tr>';
            echo '<tr>
                <th class="table_odd">Jogosultsági szint:</th>';
            $query = "SELECT moderator from users where id = '" . $id[0] . "'";
            $query_result = mysqli_query($con, $query);
            $row4 = mysqli_fetch_row($query_result);
            if ($row4[0]==1)
                
                echo '<th class="table_odd">Moderátor</th>
                </tr>';
            $query = "SELECT admin from users where id = '" . $id[0] . "'";
            $query_result = mysqli_query($con, $query);
            $row5 = mysqli_fetch_row($query_result);
            if ($row5[0]==1)
                echo '<th class="table_odd">Adminisztrátor</th>
                </tr>';
            if ($row4[0]==0 and $row5[0]==0) {
              echo '<th class="table_odd">Felhasználó</th>
                </tr>';
            }
            $query = "SELECT email from users where id = '" . $id[0] . "' and email_vis=1";
            $query_result = mysqli_query($con, $query);
            $row1 = mysqli_fetch_row($query_result);
            if (!empty($row1[0]))
            {
                echo '<tr>
                <th class="table_odd">E-mail cím:</th>
                <th class="table_odd">'.$row1[0].'</th>
            </tr>';
            }
            $query = "SELECT birth from users where id = '" . $id[0] . "' and birth_vis=1";
            $query_result = mysqli_query($con, $query);
		        $row2 = mysqli_fetch_row($query_result);
            if (!empty($row2[0]))
            {
                echo '<tr>
                <th class="table_odd">Születési dátum:</th>
                <th class="table_odd">'.$row2[0].'</th>
            </tr>';
            }
            $query = "SELECT intro from users where id = '" . $id[0] . "'";
            $query_result = mysqli_query($con, $query);
		        $row3= mysqli_fetch_row($query_result);
            if (!empty($row3[0]))
            {
                echo '<tr>
                <th class="table_odd">Bemutatkozás:</th>
                <th class="table_odd">'.$row3[0].'</th>
            </tr>';
            }
		    
        echo '</tbody></table><br>';
        $query = "SELECT email from users where id = '" . $id[0] . "'";
        $query_result = mysqli_query($con, $query);
		$row1 = mysqli_fetch_row($query_result);
        $query = "SELECT birth from users where id = '" . $id[0] . "'";
        $query_result = mysqli_query($con, $query);
        $row2 = mysqli_fetch_row($query_result);
        if ($_SESSION["admin"]==1 || $_SESSION["moderator"]==1) { //Az admin felület
            $_SESSION["masid"]=$id[0];
            echo '<form id="form-login" action="admin_check.php" method="POST">
            <fieldset class="form_2">
                <legend>'.$name.' adatainak módosítása</legend>';
                    if(strlen($email_error)>0){
                        echo '<div class="warning">';
                        echo $email_error;
                        echo "</div>";
                    }
                echo '<label for="email">E-mail cím: </label>';
                echo '<input type="email" id="email" name="email" size="25" placeholder=" '.$row1[0].'"><br><br>';
                if(strlen($user_name_error)>0){
                    echo '<div class="warning">';
                    echo $user_name_error;
                    echo "</div>";
                }
                echo '<label for="user-name">Felhasználónév: </label>';
                echo '<input type="text" id="user-name" name="user-name" size="25" placeholder=" '.$name.'"><br><br>';
                 
							if(strlen($pwd_error)>0){
								echo '<div class="warning">';
								echo $pwd_error;
								echo "</div>";
							} 
						
						
				echo '<label for="pwd">Új jelszó:</label>';
				echo '<input type="password" id="pwd" name="pwd"><br><br>';
                echo '<label for="birth">Születési dátum:</label>';
                echo '<input type="date" id="birth" name="birth" min="1920-01-01" placeholder="'.$row2[0].'"/> <br><br>';
                echo '';
                echo '<label for="intro">Bemutatkozás:</label><br>';
                echo '<textarea name="intro" rows="5" cols="45" maxlength="200" placeholder="'.$row3[0].'"></textarea><br>'; 
                echo '<label for="mode">Születésnap látható-e?</label>
                <input type="checkbox" id="mode-1" name="birth_vis" value="1"/><br>
                <label for="mode">E-mail cím látható-e?</label>
                <input type="checkbox" id="mode-2" name="email_vis" value="1"/><br>';
                if ($_SESSION["admin"]==1) {
                echo '<label for="mode">Moderátor-e</label>
                <input type="checkbox" id="mode-2" name="moderator" value="0"/><br>';
                echo '<label for="sudo">gercso mode</label>
                <input type="checkbox" id="mode-2" name="sudo" value="0"/><br>';}
                echo '<input type="reset" name="btn-reset" value="Törlés">
                <input type="submit" name="btn-submit"  value="Küldés">
                
                
            </fieldset>
            
        </form>';
        
        }

        ?>
    </main>
    <footer id="footer" class="unselectable">
      <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
  </footer>
</body>
      </html>