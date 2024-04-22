<?php
$name = $_POST['name'];
//echo $name
?>
<?php
    if(!isset($_SESSION)){session_start();
    
        $user_name_error = "";
        $pwd_error = "";
        $pwd_2_error = "";
        if(isset($_SESSION["message"])){
            $keys = array_keys($_SESSION["message"]);
            for($i=0; $i < count($_SESSION["message"]); $i++) {
                
                if ($keys[$i] == 'user_name') {
                    $user_name_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'pwd') {
                    $pwd_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'pwd_2') {
                    $pwd_2_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
            }
            
            // After we got the message, set it to null, so it doesn't linger in the system indefinitely.
            unset($_SESSION["message"]);
        } 
        }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/page_images.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/page_content.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/navbar.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/dropdown.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/animation.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/media_size.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/footer.css?v=<?php echo time(); ?>">
  <link rel="icon" href="../img/150_tablogo.png?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/form.css?v=<?php echo time(); ?>">
    <title>R150 - Profilok</title>
</head>
<nav>
    <?php include 'navbar.php' ?>
    </nav>
    <?php
       
    if(isset($_SESSION["user_name"])) {
        if ($_SESSION["admin"] == 1) {
           

      echo '<header id="form_1">
      <div class="text1">
          <h1>'.$name.' adatai:</h1>
      </div>
    </header>';
    
    
    echo '<main class="torzs table_div">';
    $query = "SELECT * from felhasznalo where email = :name";
    
    include("../controller/connection.php");
    $stmt = oci_parse($con, $query);
    oci_bind_by_name($stmt, ":name", $name);
    oci_execute($stmt);
    $row = oci_fetch_assoc($stmt);
    $id = $row;

    
    if ($_SESSION["admin"] == 1 ) { //Az admin felület
        $_SESSION["masid"] = $name;
        echo '<br><form id="form-login" action="../controller/admin_check.php" method="POST">
        <fieldset class="form_2">
            <legend>'.$name.' adatainak módosítása</legend>';
                
            if(strlen($user_name_error)>0){
                echo '<div class="warning">';
                echo $user_name_error;
                echo "</div>";
            }
            echo '<label for="user-name">Felhasználónév: </label>';
            echo '<input type="text" id="user-name" name="user-name" size="25" placeholder=" '.$name.'"><br>';
             
            if(strlen($pwd_error)>0){
                echo '<div class="warning">';
                echo $pwd_error;
                echo "</div>";
            } 
            
            
            echo '<label for="pwd">Új jelszó:</label>';
            echo '<input type="password" id="new_pwd" name="new_pwd"><br>
            <label for="new_pwd_2">Új jelszó újra:</label>
                <input type="password" id="new_pwd_2" name="new_pwd_2">
                <br>
                <label for="nev">Név:</label>
						<input type="text" id="nev" name="nev" placeholder="'.$id['NEV'].'">
						<br>

						<label for="eletkor">Életkor:</label>
						<input type="number" id="eletkor" name="eletkor" placeholder="'.$id['ELETKOR'].'">
						<br>

						<label for="kedvezmenytipus">Kedvezménytípus:</label>
						<input type="text" id="kedvezmenytipus" name="kedvezmenytipus" placeholder="'.$id['KEDVEZMENYTIPUS'].'">
						<br>

						<label for="igazolvanyszam">Igazolványszám:</label>
						<input type="text" id="igazolvanyszam" name="igazolvanyszam" placeholder="'.$id['IGAZOLVANYSZAM'].'">
						<br>';
            echo '<label for="mode">Moderátor-e</label>
            <input type="checkbox" id="mode-2" name="moderator" value="0"/><br>';
            echo '<input type="reset" name="btn-reset" value="Törlés"><br>
            <input type="submit" name="btn-submit"  value="Küldés">
            
            
        </fieldset>
        
    </form>';
    
    }
    }
    else {
        header("Location: myprofile.php");
    }
}
    

    ?>
</main>

</body>
</html>