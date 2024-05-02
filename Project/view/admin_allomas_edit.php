<?php
if (!isset($_SESSION)) {
    session_start();
}

$nev = $_POST['nev'];
$new_ticket = $_POST['new_ticket'];
include("../controller/connection.php");
$nev_error = "";
$varos_error = "";
$sikeres = "";

$problems = array();

if(isset($_SESSION["message"])){
    

    $keys = array_keys($_SESSION["message"]);
    for($i = 0; $i < count($_SESSION["message"]); $i++) {
        if ($keys[$i] == 'nev') {
            $tipus_error .= $_SESSION["message"][$keys[$i]] . ' ';
        }
        if ($keys[$i] == 'varos') {
            $ar_error .= $_SESSION["message"][$keys[$i]] . ' ';
        }
    }

    // After we got the message, set it to null, so it doesn't linger in the system indefinitely.
    unset($_SESSION["message"]);
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
<body>
<nav>
    <?php include 'navbar.php' ?>
</nav>

<?php
include ("../controller/functions.php");

if(isset($_SESSION["user_name"])) {
    if ($_SESSION["admin"] == 1 && $new_ticket == "false")  {
        echo '<main class="torzs table_div">';
        $query = "SELECT * FROM allomas WHERE nev = :nev";
        include("../controller/connection.php");
        $stmt = oci_parse($con, $query);
        oci_bind_by_name($stmt, ":nev", $nev);
        $ja = oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $id = $row;
        echo '
        <div class="text1">
            <h1>Allomás módosítása:</h1>
        </div>';

        if(strlen($nev_error)>0){
            echo '<div class="warning">';
            echo $nev_error;
            echo "</div>";
        } 

        $_SESSION["station_id"] = $nev;
        echo '<br><form id="form-login" action="../controller/allomas_edit_check.php" method="POST">
        <fieldset class="form_2">
            <legend>'.$id['NEV'].'</legend>';
        

            if(strlen($varos_error) > 0){
                echo '<div class="warning">';
                echo $varos_error;
                echo "</div>";
            }

            echo '<input type="hidden" id="station-id" name="station-id" size="25" placeholder=" '.$nev.'"><br>';
            
            if (!empty($id)) {
                echo '<label for="nev">Név:</label>
                    <input type="text" class="station_input" id="nev" name="nev" value="'.$id['NEV'].'">
                    <br>

                    <label for="varos">Város:</label>
                    <input type="text" class="station_input" id="varos" name="varos" value="'.$id['VAROS'].'">
                    <br>';
            }
                        
            echo '<input type="reset" name="btn-reset" value="Visszaállítás"><br>
            <input type="submit" name="btn-submit" value="Küldés"><br>
            </form>

            <form id="form-login" action="../controller/delete_allomas.php" method="POST">
            <input type="hidden" name="nev" value="' . $nev . '">
            <input type="submit" name="btn-delete-station" value="Állomás törlése">
            </form><br>
        </fieldset>';
    }
    elseif ($_SESSION["admin"] == 1 && $new_ticket =="true") {
        ?>
        <main class="torzs">
            <div class="anti-collapse"></div>
            <div class="form-box">
                <form id="form-login" action="../controller/new_allomas_check.php" method="POST">
                    <fieldset class="form_2">
                        <legend>Állomás létrehozása</legend>
                        <?php 
                            if(strlen($nev_error)>0){
                                echo '<div class="warning">';
                                echo $nev_error;
                                echo "</div>";
                            } 
                        ?>
                        <label for="nev">Név:</label>
                        <input type="text" class="station_input" id="nev" name="nev">
                        <br>
                        <?php 
                            if(strlen($varos_error)>0){
                                echo '<div class="warning">';
                                echo $varos_error;
                                echo "</div>";
                            } 
                        ?>
                        <label for="varos">Város:</label>
                        <input type="text" class="station_input" id="varos" name="varos">
                        <br>
                        <input class="submit-button" type="submit" name="btn-submit"  value="Létrehozás">
                    </fieldset>
                </form>
            </div>
        </main>
    <?php
    }
    else {
        header("Location: allomassearch.php");
    }
}
?>
</body>
</html>
