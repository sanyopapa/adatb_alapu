<?php
$name = $_POST['name'];
$vonatszam = $_POST['vonatszam'];
$new_ticket = $_POST['new_ticket'];

//echo $name
?>
<?php
    if(!isset($_SESSION)){session_start();
        
        $allomasnev_error = "";
        $vonatszam_error = "";
        $erkezes_error = "";
        $indulas_error = "";
        $sikeres = "";
        if(isset($_SESSION["message"])){
            $keys = array_keys($_SESSION["message"]);
            for($i=0; $i < count($_SESSION["message"]); $i++) {
                
                if ($keys[$i] == 'allomasnev') {
                    $allomasnev_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'vonatszam') {
                    $vonatszam_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'erkezes') {
                    $erkezes_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'indulas') {
                    $indulas_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'sikeres') {
                    $sikeres .= $_SESSION["message"][$keys[$i]] . ' ';
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
    <title>R150 - Kozlekedik módosítás</title>
</head>
<nav>
    <?php include 'navbar.php' ?>
    </nav>

    
    <?php
    include ("../controller/functions.php");








if(isset($_SESSION["user_name"])) {
    if ($_SESSION["admin"] == 1 && $new_ticket == "false")  {

    echo '<main class="torzs table_div">';
    $query = "SELECT * from kozlekedik where allomasnev = :name AND vonatszam= :vonatszam";
    
    include("../controller/connection.php");
    $stmt = oci_parse($con, $query);
    oci_bind_by_name($stmt, ":name", $name);
    oci_bind_by_name($stmt, ":vonatszam", $vonatszam);
    $ja=oci_execute($stmt);
    $row = oci_fetch_assoc($stmt);
    $id = $row;
    echo '
    <div class="text1">
        <h1>Közlekedő vonat módosítása:</h1>
    </div>';
    

    $_SESSION["ticketid"] = $name;
    echo '<br><form id="form-login" action="../controller/kozlekedik_edit_check.php" method="POST">
    <fieldset class="form_2">
        <legend>'.$id['ALLOMASNEV'].'</legend>';
            
        if(strlen($vonatszam_error)>0){
            echo '<div class="warning">';
            echo $vonatszam_error;
            echo "</div>";
        }
    
        echo '<input type="hidden" id="ticket-id" name="ticket-id" size="25" placeholder=" '.$name.'"><br>';
         
        if(strlen($erkezes_error)>0){
            echo '<div class="warning">';
            echo $erkezes_error;
            echo "</div>";
        } 
        
        if (!empty($id)) {
            echo '<label for="allomasnev">Állomásnév:<br>(nem változtatható):</label>
                <input type="text" class="ticket_input" id="allomasnev" name="allomasnev" value="'.$id['ALLOMASNEV'].'"readonly>
                <br>

                <label for="vonatszam">Vonatszám:</label>
                <input type="text" class="ticket_input" id="vonatszam" name="vonatszam" value="'.$id['VONATSZAM'].'">
                <br>

                <label for="erkezes">Érkezési idő:</label>
                <input type="datetime-local" class="ticket_input" id="erkezes" name="erkezes" value="'. StrToDTL($id['ERKEZES']).'">
                <br>

                <label for="indulas">Indulási idő:</label>
                <input type="datetime-local" class="ticket_input" id="indulas" name="indulas" value="'. StrToDTL($id['INDULAS']) . '">
                <br>';
               
        }
                    
        echo '<input type="reset" name="btn-reset" value="Visszaállítás"><br>
        <input type="submit" name="btn-submit"  value="Küldés"><br>
        </form>

        <form id="form-login" action="../controller/delete_kozlekedik.php" method="POST">
       
        <input type="hidden" name="allomasnev" value="' . $name . '">
        <input type="hidden" name="vonatszam" value="' . $vonatszam . '">
        <input type="submit" name="btn-delete-user" value="Vonat törlése">
        </form><br>
    </fieldset>';

   
    }
    elseif ($_SESSION["admin"] == 1 && $new_ticket =="true") {
      
        ?>
        <main class="torzs">
			
            <div class="anti-collapse"></div>
                    
            <div class="form-box">
                <form id="form-login" action="../controller/new_kozlekedik_check.php" method="POST"> <!-- Új action fájlra mutat -->
                    <fieldset class="form_2">
                        <legend>Vonat létrehozása</legend>
        
                        <?php 
                            if(strlen($allomasnev_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $allomasnev_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
                        <label for="allomasnev">Állomásnév:</label> <!-- Módosított mezőnév -->
                        <input type="text" class="ticket_input" id="allomasnev" name="allomasnev"> <!-- Módosított mezőnév -->
                        <br>
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
                            if(strlen($erkezes_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $erkezes_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
        
                        <label for="erkezes">Érkezési idő:</label> <!-- Módosított mezőnév -->
                        <input type="datetime-local" class="ticket_input" id="erkezes" name="erkezes"> <!-- Módosított mezőnév -->
                        <br>
                        <?php 
                            if(strlen($indulas_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $indulas_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
        
                        <label for="indulas">Indulási idő:</label> <!-- Módosított mezőnév -->
                        <input type="datetime-local" class="ticket_input" id="indulas" name="indulas"> <!-- Módosított mezőnév -->
                        <br>
        
                        <input class="submit-button" type="submit" name="btn-submit"  value="Létrehozás">
                    </fieldset>
                </form>
            </div>
        </main>
        


    <?php
       
    }
    else {
      
        header("Location: newssearch.php");
    }
}
    

    ?>
</main>

</body>
</html>
