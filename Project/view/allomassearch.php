<?php
if (!isset($_SESSION)) {
    session_start();
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
    <link rel="stylesheet" href="../styles/footer.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../styles/media_size.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../styles/animation.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../styles/footer.css?v=<?php echo time(); ?>">
    <link rel="icon" href="../img/150_tablogo.png?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../styles/form.css?v=<?php echo time(); ?>">


    <title>R150 Vasútmenetrend - Állomás módosítás</title>
</head>

<body>
    <nav>
        <?php include 'navbar.php' ?>
    </nav>

    <?php
    echo '
		<main class="torzs">
		<div class="text1">
		
		<h1>Állomások módosítása</h1>
		
		</div>
		';
    ?>

    <br>
    
    <?php
	if(!isset($_SESSION)){session_start();}
	include("../controller/connection.php");	

   
    $nev_error = "";
    $varos_error = "";
    $success = '';
    $deleted = '';
    
    // Check if there are any error messages stored in the session
    if(isset($_SESSION["message"])){
        
		$keys = array_keys($_SESSION["message"]);
		for($i=0; $i < count($_SESSION["message"]); $i++) {
			
            if ($keys[$i] == 'nev') {
                $nev_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'varos') {
                $varos_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }

            if($keys[$i] == 'success'){
                $success .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if($keys[$i] == 'deleted'){
                $deleted .= $_SESSION["message"][$keys[$i]] . ' ';
            }
		}
		
		// After we got the message, set it to null, so it doesn't linger in the system indefinitely.
		unset($_SESSION["message"]);
	} 
?>
    

    <?php
        include ("../controller/connection.php");

        #sikeresség/problémák kiírása
        if(strlen($nev_error)>0){
            echo '<div class="warning">';
            echo $nev_error;
            echo "</div>";
        }

        if(strlen($varos_error)>0){
            echo '<div class="warning">';
            echo $varos_error;
            echo "</div>";
        } 
        
        if(strlen($success)>0){
            echo '<div class="warning">';
            echo $success;
            echo "</div>";
            echo "<br>";
        } 
        
        if(strlen($deleted)>0){
            echo '<div class="warning">';
            echo $deleted;
            echo "</div>";
            echo "<br>";
        }



        #új állomás hozzáadása

        echo'<div class="new_news">
        <form method="POST" id="form-login" class="login-link" action="admin_allomas_edit.php">
            <label for="">Ezzel a gombbal új állomást tudsz hozzáadni.</label><br><br>
            <input type="hidden" name="nev" value="">
            <input type="hidden" name="new_ticket" value=true>
            <input type="submit" value="Új állomás">
            </form>
            </div>';



        #meglévő állomások kiírása
        $query = 'SELECT * FROM Allomas';
        $stmt = oci_parse($con, $query);
        oci_execute($stmt);


        

            echo "<table class='table_div_kozerdek table_news'>";
            echo '
            <tr>
                <th class="table_header">Név</th>
                <th class="table_header">Város</th>
                <th class="table_header" colspan="2">Szerkesztés</th>
            </tr>';
            
            $count = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                
                echo "<tr>";
                $class = $count % 2 == 1 ? 'table_even' : 'table_odd';
                $form_class = $count % 2 == 1 ? 'ticket_edit_even' : 'ticket_edit_odd';
                
                echo '<td class="' . $class . '">' . $row['NEV'] . '</td>';
                echo '<td class="' . $class . '">' . $row['VAROS'] . '</td>';
                echo '<td colspan="2" class="news_edit ' . $class . ' ' . $form_class . '">
                <form method="POST" action="admin_allomas_edit.php">
                <input type="hidden" name="nev" value="' . $row['NEV'] . '">
                <input type="hidden" name="new_ticket" value="false">
                <input type="submit" value="Módosítás">
                    </form> </td>';
                echo "</tr>";
                $count++;
            }
            
            
            echo "</table>";


        
    ?>


    </main>
    <footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a
                href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/"
                target="_blank" id="footer_link"> Github </a> oldala</p>
    </footer>
</body>

</html>
