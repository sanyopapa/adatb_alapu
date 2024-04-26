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


    <title>R150 Vasútmenetrend - Névjegy</title>
</head>

<body>
    <nav>
        <?php include 'navbar.php' ?>
    </nav>

    <?php
    echo '
		<main class="torzs">
		<div class="text1">
		
		<h1>Hírek</h1>
		
		</div>
		';
    ?>

    <br>

    <?php
        include ("../controller/connection.php");

        # Szerencsétlen CLOB mező olvasására
        function read_clob($field)
        {
            return $field->read($field->size());
        }


        $query = 'SELECT * FROM Hir';
        $stmt = oci_parse($con, $query);
        oci_execute($stmt);


        while ($row = oci_fetch_assoc($stmt)) {

            echo '<table class="table_news">';
            echo '<thead>';
            echo '<tr>';
            echo '<th colspan="2" class="table_header">' . $row['CIM'] . '</th>';
            echo '<th colspan="2" class="table_header table_date">
            
            <form method="POST" action="admin_news_edit.php">
            <input type="hidden" name="name" value=' . $row['HIRID'] . '>
            <input type="submit" value="Módosítás">
                </form> </th>';
           

            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            echo '<br>';
            echo '<br>';
            echo '<tr>';
            echo '<td class="table_odd">' . read_clob($row['SZOVEG']) . '</td>';
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