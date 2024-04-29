<?php
if (!isset($_SESSION)) {
	session_start();
}
?>

<?php
$latogatasok = 1;
if (isset($_COOKIE["visits"])) {
	$latogatasok = $_COOKIE["visits"] + 1;
}
setcookie("visits", $latogatasok, time() + (60 * 60 * 24 * 30), "/");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>R150 - Profil</title>
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
</head>

<body>
	<nav>
		<?php include 'navbar.php' ?>
	</nav>
    <main class="torzs table_div">
    <div class="text1">
		
		<h1>Állomások</h1>
		
		</div>
	<?php
	

	// Connect to the Oracle database
	include("../controller/connection.php");

	// Prepare the SQL query
    $query = "SELECT * from Allomas";

    // Execute the query
    $statement = oci_parse($con, $query);
    oci_execute($statement);

    // Fetch the results and display the buttons
    if (oci_fetch($statement)) {
        echo '<table>
        <thead>

        <tr>
            <th class="table_header">Név</th>
            <th class="table_header">Város</th>
        </tr>
        </thead>
        <tbody>';
        $stmt = oci_parse($con, $query);
        oci_execute($stmt);
        $count = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $nev = $row['NEV'];
            $varos = $row['VAROS'];

            $class = $count % 2 == 1 ? 'table_even' : 'table_odd';
            echo '<tr>
            <td class="' . $class . '">' . $nev . '</td>
            <td class="' . $class . '">' . $varos . '</td>
            </tr>';
            $count++;
        }
        echo '</tbody></table><br>';
    }

	
	oci_close($con);
	?>
	

</main>

<footer id="footer" class="unselectable">
	<p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p>
</footer>

</body>

</html>
