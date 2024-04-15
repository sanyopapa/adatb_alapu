<?php
	if(!isset($_SESSION)){session_start();}
	
	
	$user_name_error = "";
	$pwd_error = "";
	$pwd_2_error = "";
	$email_error = "";
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
	

?>

<!DOCTYPE html>
<html lang="en">
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
  <title>R150 - Dolgaid</title>
</head>
<body>
<header>
<nav>
    <?php include 'navbar.php' ?>
    </nav>
</header>
<main class="torzs">
<div class="anti-collapse"></div>

<div class="form-box">
        <form id="form-login" action="../controller/refresh_pwd_check.php" method="POST">
            <fieldset class="form_2">
                <legend>Jelszó módosítása</legend>
                <?php 
                    if(strlen($pwd_error)>0){
                        echo '<div class="warning">';
                        echo $pwd_error;
                        echo "</div>";
                    } 
                ?>
                <label for="pwd">Régi jelszó:</label>
                <input type="password" id="pwd" name="pwd" required>
                <br>
                <?php 
                   /*  if(strlen($pwd_error)>0){
                        echo '<div class="warning">';
                        echo $pwd_error;
                        echo "</div>";
                    }  */
                ?>
                
                <label for="new_pwd">Jelszó:</label>
                <input type="password" id="new_pwd" name="new_pwd" required>
                <br>
                
                <?php 
                    if(strlen($pwd_2_error)>0){
                        echo '<div class="warning">';
                        echo $pwd_2_error;
                        echo "</div>";
                    } 
                ?>
                
                <label for="new_pwd_2">Jelszó újra:</label>
                <input type="password" id="new_pwd_2" name="new_pwd_2" required>
                <br>
                <input type="reset" name="btn-reset" value="Törlés"><br>
                <input type="submit" name="btn-submit"  value="Küldés">
            </fieldset>
        </form>
    </div>
</main>    
<footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
</body>
</html>