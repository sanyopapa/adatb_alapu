<?php
$name = $_POST['name'];
$new_news = $_POST['new_news'];

//echo $name
?>
<?php
    if(!isset($_SESSION)){session_start();
    
        $cim_error = "";
        $szoveg_error = "";
        $sikeres = "";
        if(isset($_SESSION["message"])){
            $keys = array_keys($_SESSION["message"]);
            for($i=0; $i < count($_SESSION["message"]); $i++) {
                
                if ($keys[$i] == 'cim') {
                    $cim_error .= $_SESSION["message"][$keys[$i]] . ' ';
                }
                if ($keys[$i] == 'szoveg') {
                    $szoveg_error .= $_SESSION["message"][$keys[$i]] . ' ';
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
     # Szerencsétlen CLOB mező olvasására
     function read_clob($field)
     {
         return $field->read($field->size());
     }
       
    if(isset($_SESSION["user_name"])) {
        if ($_SESSION["admin"] == 1 && $new_news == "false")  {
           
        echo '<main class="torzs table_div">';
        $query = "SELECT * from hir where hirid = :name";
        
        include("../controller/connection.php");
        $stmt = oci_parse($con, $query);
        oci_bind_by_name($stmt, ":name", $name);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $id = $row;
        
        echo '
        <div class="text1">
            <h1>Hír módosítása:</h1>
        </div>';
        
    
    
        $_SESSION["newsid"] = $name;
        echo '<br><form id="form-login" action="../controller/news_check.php" method="POST">
        <fieldset class="form_2">
            <legend>'.$id['CIM'].'</legend>';
                
            if(strlen($cim_error)>0){
                echo '<div class="warning">';
                echo $cim_error;
                echo "</div>";
            }
        
            echo '<input type="hidden" id="hir-id" name="hir-id" size="25" placeholder=" '.$name.'"><br>';
             
            if(strlen($szoveg_error)>0){
                echo '<div class="warning">';
                echo $szoveg_error;
                echo "</div>";
            } 
        
            echo '<label for="cim">Cím:</label>
						<input type="text" class="news_input" id="cim" name="cim" value="'.$id['CIM'].'">
						<br>

						<label for="szoveg">Szöveg:</label>
						<textarea class="news_submissionfield" id="szoveg" name="szoveg">'.read_clob($id['SZOVEG']).'</textarea>
						<br>';

						#<label for="datum">Dátum:</label>
					echo'<input type="hidden" class="news_input" id="datum" name="datum" placeholder="'.$id['DATUM'].'">
						<br>';

						
            echo '<input type="reset" name="btn-reset" value="Visszaállítás"><br>
            <input type="submit" name="btn-submit"  value="Küldés"><br>
            </form>

            <form id="form-login" action="../controller/delete_news.php" method="POST">
           
            <input type="hidden" name="name" value=' . $name . '>
            <input type="submit" name="btn-delete-user" value="Hír törlése">
            </form><br>
        </fieldset>';
    
   
    }
    elseif ($_SESSION["admin"] == 1 && $new_news =="true") {
      
        ?>

        <main class="torzs">
			
			<div class="anti-collapse"></div>
			
			<div class="form-box">
				<form id="form-login" action="../controller/new_news_check.php" method="POST">
					<fieldset class="form_2">
						<legend>Hír létrehozása</legend>

                        <?php 
                            if(strlen($cim_error)>0){
                                echo '<div class="warning">';
                                echo $cim_error;
                                echo "</div>";
                            } 
                        ?>
                        <label for="cim">Cím:</label>
                        <input type="text" class="news_input" id="cim" name="cim">
                        <br>
                        <?php 
                            if(strlen($szoveg_error)>0){
                                echo '<div class="warning">';
                                echo $szoveg_error;
                                echo "</div>";
                            } 
                        ?>

                        <label for="szoveg">Szöveg:</label>
                        <textarea class="news_submissionfield" id="szoveg" name="szoveg"></textarea>
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