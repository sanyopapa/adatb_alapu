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


    <title>R150 Vasútmenetrend - Hírmódosítás</title>
</head>

<body>
    <nav>
        <?php include 'navbar.php' ?>
    </nav>

    <?php
    echo '
		<main class="torzs">
		<div class="text1">
		
		<h1>Hírek módosítása</h1>
		
		</div>
		';
    ?>

    <br>
    
    <?php
	if(!isset($_SESSION)){session_start();}
	include("../controller/connection.php");	

   
    $cim_error = "";
    $szoveg_error = "";
    $success = '';
    
    // Check if there are any error messages stored in the session
    if(isset($_SESSION["message"])){
        
		$keys = array_keys($_SESSION["message"]);
		for($i=0; $i < count($_SESSION["message"]); $i++) {
			
            if ($keys[$i] == 'cim') {
                $cim_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'szoveg') {
                $szoveg_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }

            if($keys[$i] == 'success'){
                $success .= $_SESSION["message"][$keys[$i]] . ' ';
            }
		}
		
		// After we got the message, set it to null, so it doesn't linger in the system indefinitely.
		unset($_SESSION["message"]);
	} 
?>
    

    <?php
        include ("../controller/connection.php");

        # Szerencsétlen CLOB mező olvasására
        function read_clob($field)
        {
            return $field->read($field->size());
        }

        #sikeresség/problémák kiírása
        if(strlen($cim_error)>0){
            echo '<div class="warning">';
            echo $cim_error;
            echo "</div>";
        }

        if(strlen($szoveg_error)>0){
            echo '<div class="warning">';
            echo $szoveg_error;
            echo "</div>";
        } 
        
        if(strlen($success)>0){
            echo '<div class="warning">';
            echo $success;
            echo "</div>";
            echo "<br>";
        } 



        #új hír hozzáadása

        echo'<div class="new_news">
        <form method="POST" id="form-login" class="login-link" action="admin_news_edit.php">
            <label for="">Ezzel a gombbal új hírt tudsz kiírni.</label><br><br>
            <input type="hidden" name="name" value="">
            <input type="hidden" name="new_news" value=true>
            <input type="submit" value="Új hír">
            </form>
            </div>';



        #meglevő hírek kiírása
        $query = 'SELECT * FROM Hir ORDER BY DATUM DESC';
        $stmt = oci_parse($con, $query);
        oci_execute($stmt);


        while ($row = oci_fetch_assoc($stmt)) {

            echo '<table class="table_news">';
            echo '<thead>';
            echo '<tr>';
            echo '<th colspan="2" class="table_header" id="news">' . $row['CIM'] . '</th>';
            echo '<th colspan="2" class="news_edit">
            <form method="POST" action="admin_news_edit.php">
            <input type="hidden" name="name" value=' . $row['HIRID'] . '>
            <input type="hidden" name="new_news" value=false>
            <input type="submit" value="Módosítás">
                </form> </th>';
          

            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            echo '<br>';
            echo '<br>';
            echo '<tr>';
            echo '<td id="news_odd" class="table_odd">' . read_clob($row['SZOVEG']) . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td class="table_date">' . date('Y-m-d', strtotime($row['DATUM'])) . '</td>';
            echo '</tr>';
            echo '</table>';
            
        }
    ?>


    </main>
    <footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a
                href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/"
                target="_blank" id="footer_link"> Github </a> oldala</p>
    </footer>
</body>

</html>