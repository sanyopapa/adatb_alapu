<?php
	if(!isset($_SESSION)){session_start();}
	include("../controller/connection.php");	

    $email_error = '';
    $success = '';
    
    // Check if there are any error messages stored in the session
    if(isset($_SESSION["message"])){
        
		$keys = array_keys($_SESSION["message"]);
		for($i=0; $i < count($_SESSION["message"]); $i++) {
			
			if ($keys[$i] == 'email') {
				$email_error .= $_SESSION["message"][$keys[$i]] . ' ';
			}

            if($keys[$i] == 'success'){
                $success .= $_SESSION["message"][$keys[$i]] . ' ';
            }
		}
		
		// After we got the message, set it to null, so it doesn't linger in the system indefinitely.
		unset($_SESSION["message"]);
	} 
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	<title>R150 - Bérletek</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="PHP examples.">
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
	</head>
	<body>
	
		<header>
		<nav>
    <?php include 'navbar.php' ?>
    </nav>
		</header>
		<main class="torzs">
			
			
			<?php 
                if(!isset($_SESSION["user_name"])){
                    header("Location: ../view/login_check.php");
                }
                else {
                    if (strtolower($_SESSION["kedvezmenytipus"]) == 'diák') {
                        echo '
                        <p>
                        Diákkedvezményt állítottál be. Emiatt a kedvezményes árú bérletek jelennek meg. Ha teljesárú bérletet szeretnél, módosítsd az adataid <a href="refresh_pwd_page.php">itt</a>
                        </p>
                        ';
                    }
                    else {
                        echo '<p>
                        Nem állítottál be kedvezményt. Emiatt a teljesárú bérletek jelennek meg. Ha diák vagy, módosítsd az adataid <a href="refresh_pwd_page.php">itt</a>
                    </p>';
                    }
                }
            ?>
			<div class="torzs">

                <form id="form-passes" action="../controller/passes_check.php" method="POST">
                    <fieldset class="form_2">
                        <legend>Bérletvétel</legend>
                        
                        <?php 
                            if(strlen($success)>0){
                                echo '<div class="warning">';
                                echo $success;
                                echo "</div>";
                                echo "<br>";
                            } 
                        ?>
                        
                        <label for="passes-type">Bérlettípus:</label>
                        <select id="passes-type" name="passes-type" required>
                            <option value="">Válasszon bérlet</option>
                            <?php
                                // Assuming you have a database connection to Oracle and a table named 'jegy' with a column named 'tipus'
                                if (strtolower($_SESSION["kedvezmenytipus"]) == 'diák') {
                                    $query = "SELECT Tipus FROM Jegy WHERE Tipus LIKE '%Kedvezményes%' AND Tipus LIKE '%bérlet%'";
                                }
                                else {
                                    $query = "SELECT Tipus FROM Jegy WHERE Tipus NOT LIKE '%Kedvezményes%' AND Tipus LIKE '%bérlet%'";
                                }
                                //$query = "SELECT Tipus FROM Jegy WHERE Tipus LIKE '%bérlet%'";
                                $stmt = oci_parse($con, $query);
                                oci_execute($stmt);
                                
                                while ($row = oci_fetch_assoc($stmt)) {
                                    
                                    /* echo '<option value="' . "szia" . '">' . "Szia" . '</option>'; */
                                    echo '<option value="' . $row['TIPUS'] . '">' . $row['TIPUS'] . '</option>';
                                }
                                
                                oci_free_statement($stmt);
                                oci_close($con);
                            ?>
                        </select>
                        
                        
                        <br>

                        <?php 
                            if(strlen($email_error)>0){
                                echo '<div class="warning">';
                                echo $email_error;
                                echo "</div>";
                                echo "<br>";
                            } 
                        ?>
                        
                        
                        <label for="kezdet">Érvényesség kezdete (Ha nem adsz meg semmit, a mai dátum lesz):</label>
                        <input type="date" id="kezdet" name="kezdet" >
                        <br>
                        
                        <input class="submit-button" type="submit" name="btn-submit"  value="Megvétel">
                        <!-- <a href='regist_page.php' class="login-link">Regisztráció</a> -->
                    </fieldset>
                </form>	
			</div>
		</main>
		<footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
	
	</body>
</html>

    <!-- TODO jegyeim mutatása -->
        <!-- TODO menetrend?-->
        <!-- TODO ki mit tud létrehozni, módosítani-->