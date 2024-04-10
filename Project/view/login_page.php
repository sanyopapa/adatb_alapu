<?php
	if(!isset($_SESSION)){session_start();}
	
	$user_name_error = "";
	$pwd_error = "";
	if(isset($_SESSION["message"])){
		$keys = array_keys($_SESSION["message"]);
		for($i=0; $i < count($_SESSION["message"]); $i++) {
			
			if ($keys[$i] == 'user_name') {
				$user_name_error .= $_SESSION["message"][$keys[$i]] . ' ';
			}
			if ($keys[$i] == 'pwd') {
				$pwd_error .= $_SESSION["message"][$keys[$i]] . ' ';
			}
		}
		
		// After we got the message, set it to null, so it doesn't linger in the system indefinitely.
		unset($_SESSION["message"]);
	} 
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	<title>R150 - Bejelentkezés</title>
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
		<main>
			
			<div class="anti-collapse"></div>
			
			<div class="torzs">
				<form id="form-login" action="../controller/login_check.php" method="POST">
					<fieldset class="form_2">
						<legend>Bejelentkezés</legend>
						
						<?php 
							if(strlen($user_name_error)>0){
								echo '<div class="warning">';
								echo $user_name_error;
								echo "</div>";
							} 
						?>
						<label for="user-name">Felhasználónév:</label>
						<input type="text" id="user-name" name="user-name" size="25" required>
						<br>
						
						<?php 
							if(strlen($pwd_error)>0){
								echo '<div class="warning">';
								echo $pwd_error;
								echo "</div>";
							} 
						?>
						
						<label for="pwd">Jelszó:</label>
						<input type="password" id="pwd" name="pwd" required>
						<br>
						
						<input class="submit-button" type="submit" name="btn-submit"  value="Bejelentkezés">
						<a href='regist_page.php' class="login-link">Regisztráció</a>
					</fieldset>
				</form>	
			</div>
		</main>
		<footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
	
	</body>
</html>