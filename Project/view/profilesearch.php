<?php
	if(!isset($_SESSION)){session_start();}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>R150 - Profilok</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="PHP examples.">
		<link rel="stylesheet" href="../style/main_style.css?v=<?php echo time(); ?>">
		<link rel="stylesheet" href="../style/form_style.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../style/profiles.css?v=<?php echo time(); ?>">
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
	<nav>
    <?php include 'navbar.php' ?>
    </nav>
  <?php
    if(isset($_SESSION["user_name"])) {
        if ($_SESSION["admin"] == 1) {
      echo '<header id="form_1">
      <div class="text1">
          <h1>Regisztrált emberek listája:</h1>
      </div>
    </header>';
    
    $query = "SELECT felhasznalonev FROM fiokok WHERE felhasznalonev != '" . $_SESSION['user_name'] . "' ORDER BY felhasznalonev";
    include("../controller/connection.php");
    $query_result = oci_parse($con, $query);
    oci_execute($query_result);
    echo '<main class="profiles_div">';
    while ($row = oci_fetch_row($query_result)) {
        echo '<form method="POST" action="admin_page_edit.php">
        <label for="name">Felhasználók:</label><br>
        <input type="hidden" name="name" value='.$row[0].'>
        <input type="submit" value='.$row[0].'>
            </form>';
        }
    }
        else {
            header("Location: myprofile.php");
        }
    }
   
    
    ?>
        
    </main>
    <footer id="footer" class="unselectable">
      <p class="footer-p">A projekt <a href="https://github.com/DeeAyDan/szte_webprog_projekt" target="_blank" id="footer_link"> Github </a> oldala</p> 
  </footer>
</body>
</html>