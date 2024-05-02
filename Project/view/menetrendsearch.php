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


    <title>R150 Vasútmenetrend - Járatmódosítás</title>
</head>

<body>
    <nav>
        <?php include 'navbar.php' ?>
    </nav>

    <?php
    echo '
		<main class="torzs">
		<div class="text1">
		
		<h1>Járatok módosítása</h1>
		
		</div>
		';
    ?>

    <br>
    
    <?php
	if(!isset($_SESSION)){session_start();}
	include("../controller/connection.php");	

   
    $vonatszam_error = "";
    $honnan_error = "";
    $hova_error = "";
    $indulasi_ido_error = "";
    $menetido_error = "";
    $vonattipus_error = "";
    $success = '';
    $deleted = '';
    
    // Check if there are any error messages stored in the session
    if(isset($_SESSION["message"])){
        
		$keys = array_keys($_SESSION["message"]);
		for($i=0; $i < count($_SESSION["message"]); $i++) {
			
            if ($keys[$i] == 'vonatszam') {
                $vonatszam_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'honnan') {
                $honnan_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'hova') {
                $hova_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'indulasi_ido') {
                $indulasi_ido_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'menetido') {
                $menetido_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'vonattipus') {
                $vonattipus_error .= $_SESSION["message"][$keys[$i]] . ' ';
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
        include ("../controller/functions.php");

        #sikeresség/problémák kiírása
        if(strlen($vonatszam_error)>0){
            echo '<div class="warning">';
            echo $vonatszam_error;
            echo "</div>";
        }

        if(strlen($honnan_error)>0){
            echo '<div class="warning">';
            echo $honnan_error;
            echo "</div>";
        } 
        if(strlen($hova_error)> 0){
            echo '<div class="warning">';
            echo $hova_error;
            echo "</div>";
        }
        if(strlen($indulasi_ido_error)>0){
            echo '<div class="warning">';
            echo $indulasi_ido_error;
            echo "</div>";
        }

        if(strlen($menetido_error)>0){
            echo '<div class="warning">';
            echo $menetido_error;
            echo "</div>";
        } 
        
        if(strlen($vonattipus_error)>0){
            echo '<div class="warning">';
            echo $vonattipus_error;
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



        #új hír hozzáadása

        echo'<div class="new_news">
        <form method="POST" id="form-login" class="login-link" action="admin_menetrend_edit.php">
            <label for="">Ezzel a gombbal új elemet tudsz kiírni a menetrendbe.</label><br><br>
            <input type="hidden" name="name" value="">
            <input type="hidden" name="new_ticket" value=true>
            <input type="submit" value="Új elem">
            </form>
            </div>';



        #meglevő hírek kiírása
        $query = 'SELECT * FROM Jarat';
        $stmt = oci_parse($con, $query);
        oci_execute($stmt);


        

            echo "<table class='table_centered'>";
            echo '
            <tr>
                <th class="table_header">Vonatszám</th>
                <th class="table_header">Honnan</th>
                <th class="table_header">Hova</th>
                <th class="table_header" id="th_big">Indulási idő</th>
                <th class="table_header">Menetidő</th>
                <th class="table_header">Vonattípus</th>
                <th class="table_header" colspan="2">Szerkesztés</th>
            </tr>';
            
            $count = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                
                echo "<tr>";
                $class = $count % 2 == 1 ? 'table_even' : 'table_odd';
                $form_class = $count % 2 == 1 ? 'ticket_edit_even' : 'ticket_edit_odd';
                
                echo '<td class="' . $class . '">' . $row['VONATSZAM'] . '</td>';
                echo '<td class="' . $class . '">' . $row['HONNAN'] . '</td>';
                echo '<td class="' . $class . '">' . $row['HOVA'] . '</td>';
                echo '<td class="' . $class . '">' . DateToStr($row['INDULASI_IDO']) . '</td>';
                echo '<td class="' . $class . '">' . DateToHour($row['MENETIDO']) . '</td>';
                echo '<td class="' . $class . '">' . $row['VONATTIPUS'] . '</td>';
                echo '<td colspan="2" class="news_edit ' . $class . ' ' . $form_class . '">
                <form method="POST" action="admin_menetrend_edit.php">
                <input type="hidden" name="name" value="' . $row['VONATSZAM'] . '">
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
