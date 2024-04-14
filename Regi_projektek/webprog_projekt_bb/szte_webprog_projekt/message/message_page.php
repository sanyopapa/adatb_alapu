<?php
	if(!isset($_SESSION)){session_start();}
	include("message_functions.php");

	$partner_error = "";
	if(isset($_SESSION["message"])){
		if($_SESSION["message"] == -1){
			$partner_error = "Not found";
		}
		unset($_SESSION["message"]);
	}
	if(isset($_SESSION["chat-partner"])){
		$partner = $_SESSION["chat-partner"];
	}
	if(!isset($partner)) {
		$partner = null;
	}
	$message_array = array();
	if(isset($_SESSION["message_array"])){
		$message_array = $_SESSION["message_array"];
		$partner = $_SESSION["chat-partner"];
		unset($_SESSION["message_array"]);
	}
	else {  
		$message_array = get_messages();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>webtervezés - regist-login</title>
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
  <link rel="stylesheet" href="styles/form.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="../style/message.css?v=<?php echo time(); ?>">
	
</head>
<body>
	<header>
	<nav class="navbar">
    <button class="navbar-gomb" onclick="location.href= '../index.php'">Főoldal</button>
    <button class="navbar-gomb" onclick="location.href= '../about.php'">Rólunk</button>
    <div class="dropgomb">
      <button class="navbar-gomb">Vonatok</button>
      <div class="dropdown">
        <a class="inactive_dropdown" href="../samu.php">Samu</a>
        <a class="inactive_dropdown" href="../pupos.php">Púpos</a>           
      </div>
    </div>
    <button class="navbar-gomb" onclick="location.href= '../contact.php'">Elérhetőségek</button>
    <?php
      if(isset($_SESSION["user_name"])){
        echo '<div class="dropgomb">
      <button class="navbar-gomb active-navbar-button">Dolgaid</button>
      <div class="dropdown">
        <a class="inactive_dropdown" href="../myprofile.php">Saját profil</a>
        <a class="inactive_dropdown" href="../refresh_others_page.php">Adatok módosítása</a>
        <a class="inactive_dropdown" href="../refresh_pwd_page.php">Jelszó módosítása</a>
		<a class="inactive_dropdown" href="../myforms.php">Beküldött űrlapjaid</a>
		<a class="active_dropdown" href="message_page.php">Beszélgetések</a>
		<a class="inactive_dropdown" href="../profilesearch.php">Profilok</a>
		<a class="inactive_dropdown" href="../logout.php">Kijelentkezés</a>
      </div>
    </div>';
        echo '<button class="navbar-gomb" onclick="location.href= '."'../form.php'".'">Űrlap</button>';
      }
      else {
        echo '<button class="navbar-gomb" onclick="location.href= '."'../login_page.php'".'">Bejelentkezés</button>';
      }
    ?>
    <div>
      <img class="profile_pic" src="../img/150_white_logo.png" alt="Fenti logó">
    </div>
  </nav>
	</header>
	<main>
		<div class="anti-collapse"></div>
		
		<div class="message-grid">
			<div class="friends-box">
				<?php
				echo "user: " . $_SESSION["user_name"].'<br>';
				if(isset($partner) and $partner and strlen($partner_error) == 0){
					echo 'Chatting with: ' . $partner."<br>";
				}
				?>
				<?php
					
					$query = "select user_name from users where user_name != '" . $_SESSION['user_name'] . "'";
					include("../connection.php");
					$query_result = mysqli_query($con, $query);
					echo "Elérhető emberek: ";
					while ($row = mysqli_fetch_row($query_result)) {
						echo "<br>".$row[0]." ";
					}
				?>
				<form id="chat-partnet-selector" action="select_chat_partner.php" method="POST">
					<?php 
						if(strlen($partner_error)>0){
							echo '<div style="color:red;">' . $partner_error . "</div>";
						}
						elseif( !isset($partner) or !$partner){
							echo '<div style="color:red;">Chat partner should be selected!</div>';
						} 
					?>
					<input type="text"  id="chat-partner" name="chat-partner" rows="1" cols="10" maxlength="200">
					<input type="submit" name="btn-submit"  value="Select chat partner">
					
				</form>
				<a class='login-link login-link-a' href='../logout.php'>logout</a>
			</div>
		
			<div class="chat-stuff">
				<iframe class="message-box" src="message_box.php" ></iframe>
				
				<form id="chat" action="message_loader.php" method="POST">
					<input type="text" id="partner" name="partner", value=<?php echo '"' . $partner . '"'; ?> style="display: none;">
				
					<textarea id="chat-area" name="chat-input" rows="1" cols="50" maxlength="200"></textarea>
						<input class="chat_buttons" type="reset" name="btn-reset" value="Clear">
						<input class="chat_buttons" type="submit" name="btn-submit"  value="Submit">
				</form>
			</div>
		</div>
	
	</main>
	<footer id="footer" class="unselectable">
      <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
  </footer>
</body>
</html>