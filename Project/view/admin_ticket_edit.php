<?php
$name = $_POST['name'];
$new_ticket = $_POST['new_ticket'];

//echo $name
?>
<?php
    if(!isset($_SESSION)){session_start();
        
        $tipus_error = "";
        $ar_error = "";
        $feltetel_error = "";
        $idotartam_error = "";
        $sikeres = "";
        if(isset($_SESSION["message"])){
            $keys = array_keys($_SESSION["message"]);
            for($i=0; $i < count($_SESSION["message"]); $i++) {
                
                if ($keys[$i] == 'tipus') {
                    $tipus_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'cim') {
                    $ar_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'feltetel') {
                    $feltetel_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'idotartam') {
                    $idotartam_error .= $_SESSION["message"][$keys[$i]] . ' ';
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
    <title>R150 - Hírmódosítás</title>
</head>
<nav>
    <?php include 'navbar.php' ?>
    </nav>

    
    <?php
include ("../controller/functions.php");


if(isset($_SESSION["user_name"])) {
    if ($_SESSION["admin"] == 1 && $new_ticket == "false")  {

    echo '<main class="torzs table_div">';
    $query = "SELECT * from jegy where tipus = :name";
    
    include("../controller/connection.php");
    $stmt = oci_parse($con, $query);
    oci_bind_by_name($stmt, ":name", $name);
    $ja=oci_execute($stmt);
    $row = oci_fetch_assoc($stmt);
    $id = $row;
    echo '
    <div class="text1">
        <h1>Jegy módosítása:</h1>
    </div>';
    

    $_SESSION["ticketid"] = $name;
    echo '<br><form id="form-login" action="../controller/ticket_edit_check.php" method="POST">
    <fieldset class="form_2">
        <legend>'.$id['TIPUS'].'</legend>';
            
        if(strlen($ar_error)>0){
            echo '<div class="warning">';
            echo $ar_error;
            echo "</div>";
        }
    
        echo '<input type="hidden" id="ticket-id" name="ticket-id" size="25" placeholder=" '.$name.'"><br>';
         
        if(strlen($feltetel_error)>0){
            echo '<div class="warning">';
            echo $feltetel_error;
            echo "</div>";
        } 

        if (!empty($id)) {
            echo '<label for="tipus">Típus<br>(nem változtatható):</label>
                <input type="text" class="ticket_input" id="tipus" name="tipus" value="'.$id['TIPUS'].'"readonly>
                <br>

                <label for="ar">Ár:</label>
                <input type="text" class="ticket_input" id="ar" name="ar" value="'.$id['AR'].'">
                <br>

                <label for="feltetel">Feltétel:</label>
                <textarea class="ticket_submissionfield" id="feltetel" name="feltetel">'.read_clob($id['FELTETEL']).'</textarea>
                <br>

                <label for="idotartam">Időtartam:</label>
                <input type="text" class="ticket_input" id="idotartam" name="idotartam" value="'.$id['IDOTARTAM'].'">
                <br>';
        }
                    
        echo '<input type="reset" name="btn-reset" value="Visszaállítás"><br>
        <input type="submit" name="btn-submit"  value="Küldés"><br>
        </form>

        <form id="form-login" action="../controller/delete_ticket.php" method="POST">
       
        <input type="hidden" name="tipus" value="' . $name . '">
        <input type="submit" name="btn-delete-user" value="Jegy törlése">
        </form><br>
    </fieldset>';

   
    }
    elseif ($_SESSION["admin"] == 1 && $new_ticket =="true") {
      
        ?>
        <main class="torzs">
			
            <div class="anti-collapse"></div>
                    
            <div class="form-box">
                <form id="form-login" action="../controller/new_ticket_check.php" method="POST"> <!-- Új action fájlra mutat -->
                    <fieldset class="form_2">
                        <legend>Jegy létrehozása</legend>
        
                        <?php 
                            if(strlen($tipus_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $tipus_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
                        <label for="tipus">Típus:</label> <!-- Módosított mezőnév -->
                        <input type="text" class="ticket_input" id="tipus" name="tipus"> <!-- Módosított mezőnév -->
                        <br>
                        <?php 
                            if(strlen($ar_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $ar_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
        
                        <label for="ar">Ár:</label> <!-- Módosított mezőnév -->
                        <input type="text" class="ticket_input" id="ar" name="ar"> <!-- Módosított mezőnév -->
                        <br>
                        <?php 
                            if(strlen($idotartam_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $idotartam_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
        
                        <label for="idotartam">Időtartam:</label> <!-- Módosított mezőnév -->
                        <input type="text" class="ticket_input" id="idotartam" name="idotartam"> <!-- Módosított mezőnév -->
                        <br>
        
                        <?php 
                            if(strlen($feltetel_error)>0){ // Módosított változónevek
                                echo '<div class="warning">';
                                echo $feltetel_error; // Módosított változónevek
                                echo "</div>";
                            } 
                        ?>
        
                        <label for="feltetel">Feltétel:</label> <!-- Módosított mezőnév -->
                        <textarea class="ticket_submissionfield" id="feltetel" name="feltetel"></textarea> <!-- Módosított mezőnév -->
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