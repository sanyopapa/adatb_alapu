<?php
$name = $_POST['name'];
$new_ticket = $_POST['new_ticket'];

//echo $name
?>
<?php
    if(!isset($_SESSION)){session_start();
        
        $vonatszam_error = "";
        $honnan_error = "";
        $hova_error = "";
        $indulasi_ido_error = "";
        $menetido_error = "";
        $vonattipus_error = "";
        $success = "";
        if(isset($_SESSION["message"])){
            $keys = array_keys($_SESSION["message"]);
            for($i=0; $i < count($_SESSION["message"]); $i++) {
                
                if ($keys[$i] == 'vonatszam') {
                    $vonatszam_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'honnan') {
                    $honnan_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'hova') {
                    $hova_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'indulasi_ido') {
                    $indulasi_ido_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'menetido') {
                    $menetido_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'vonattipus') {
                    $vonattipus_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'success') {
                    $success .= $_SESSION["message"][$keys[$i]] . ' ';
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
    <title>R150 - Járatmódosítás</title>
</head>
<nav>
    <?php include 'navbar.php' ?>
    </nav>

    
    <?php
    include ("../controller/functions.php");


if(isset($_SESSION["user_name"])) {
    if ($_SESSION["admin"] == 1 && $new_ticket == "false")  {

    echo '<main class="torzs table_div">';
    $query = "SELECT * from jarat where vonatszam = :name";
    
    include("../controller/connection.php");
    $stmt = oci_parse($con, $query);
    oci_bind_by_name($stmt, ":name", $name);
    $ja=oci_execute($stmt);
    $row = oci_fetch_assoc($stmt);
    $id = $row;
    echo '
    <div class="text1">
        <h1>Járat módosítása:</h1>
    </div>';
    

    $_SESSION["jaratid"] = $name;
    echo '<br><form id="form-login" action="../controller/menetrend_edit_check.php" method="POST">
    <fieldset class="form_2">
        <legend>'.$id['VONATSZAM'].'</legend>';
            
        if(strlen($honnan_error)>0){
            echo '<div class="warning">';
            echo $honnan_error;
            echo "</div>";
        }
    
        echo '<input type="hidden" id="jarat-id" name="jarat-id" size="25" placeholder=" '.$name.'"><br>';
         
        if(strlen($hova_error)>0){
            echo '<div class="warning">';
            echo $hova_error;
            echo "</div>";
        } 

        if (!empty($id)) {
            echo '<label for="vonatszam">Vonatszám<br>:</label>
                <input type="text" class="ticket_input" id="vonatszam" name="vonatszam" value="'.$id['VONATSZAM'].'">
                <br>

                <label for="honnan">Honnan:</label>
                <input type="text" class="ticket_input" id="honnan" name="honnan" value="'.$id['HONNAN'].'">
                <br>

                <label for="hova">Hova:</label>
                <input type="text" class="ticket_input" id="hova" name="hova" value="'.$id['HOVA'].'">
                <br>

                <label for="indulasi_ido">Indulási idő:</label>
                <input type="datetime-local" class="ticket_input" id="indulasi_ido" name="indulasi_ido" value="'.StrToDTL($id['INDULASI_IDO']).'">
                <br>

                <label for="menetido">Menetidő:</label>
                <input type="datetime-local" class="ticket_input" id="menetido" name="menetido" value="'.StrToDTL($id['MENETIDO']).'">
                <br>

                <label for="vonattipus">Vonattípus:</label>
                <input type="text" class="ticket_input" id="vonattipus" name="vonattipus" value="'.$id['VONATTIPUS'].'">
                <br>';
        }
                    
        echo '<input type="reset" name="btn-reset" value="Visszaállítás"><br>
        <input type="submit" name="btn-submit"  value="Küldés"><br>
        </form>

        <form id="form-login" action="../controller/delete_menetrend.php" method="POST">
       
        <input type="hidden" name="vonatszam" value="' . $name . '">
        <input type="submit" name="btn-delete-user" value="Járat törlése">
        </form><br>
    </fieldset>';

   
    }
    elseif ($_SESSION["admin"] == 1 && $new_ticket =="true") {
      
        ?>
        <main class="torzs">
			
            <div class="anti-collapse"></div>
                    
            <div class="form-box">
                <form id="form-login" action="../controller/new_menetrend_check.php" method="POST"> <!-- Új action fájlra mutat -->
                    <fieldset class="form_2">
                        <legend>Járat létrehozása</legend>
        
                        <?php 
                            if(strlen($vonatszam_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $vonatszam_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
                        <label for="vonatszam">Vonatszám:</label> <!-- Módosított mezőnév -->
                        <input type="text" class="ticket_input" id="vonatszam" name="vonatszam"> <!-- Módosított mezőnév -->
                        <br>
                        <?php 
                            if(strlen($honnan_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $honnan_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
        
                        <label for="honnan">Honnan:</label> <!-- Módosított mezőnév -->
                        <input type="text" class="ticket_input" id="honnan" name="honnan"> <!-- Módosított mezőnév -->
                        <br>
                        <?php 
                            if(strlen($hova_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $hova_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
        
                        <label for="hova">Hova:</label> <!-- Módosított mezőnév -->
                        <input type="text" class="ticket_input" id="hova" name="hova"> <!-- Módosított mezőnév -->
                        <br>
                        <?php 
                            if(strlen($indulasi_ido_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $indulasi_ido_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
        
                        <label for="indulasi_ido">Indulási idő:</label> <!-- Módosított mezőnév -->
                        <input type="datetime-local" class="ticket_input" id="indulasi_ido" name="indulasi_ido"> <!-- Módosított mezőnév -->
                        <br>
                        <?php 
                            if(strlen($menetido_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $menetido_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
        
                        <label for="menetido">Menetidő:</label> <!-- Módosított mezőnév -->
                        <input type="datetime-local" class="ticket_input" id="menetido" name="menetido"> <!-- Módosított mezőnév -->
                        <br>
                        <?php 
                            if(strlen($vonattipus_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $vonattipus_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
        
                        <label for="vonattipus">Vonattípus:</label> <!-- Módosított mezőnév -->
                        <input type="text" class="ticket_input" id="vonattipus" name="vonattipus"> <!-- Módosított mezőnév -->
                        <br>
        
                        <input class="submit-button" type="submit" name="btn-submit"  value="Létrehozás">
                    </fieldset>
                </form>
            </div>
        </main>
        


    <?php
       
    }
    else {
      
        header("Location: menetrendsearch.php");
    }
}
    

    ?>
</main>

</body>
</html>
