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
	<title>R150 - Dolgaid</title>
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
	<?php
    if (isset($_SESSION["user_name"])) {
		echo '
		
		<div class="text1">
		
		<h1>Alacsonypadlós szerelvények</h1>
		<h1><br></h1>
		</div>
		';
	}

    function getAlacsonypadlos($con) {
        include("../controller/connection.php");
        $stid = oci_parse($con, 'BEGIN :cursor := get_alacsonypadlos; END;');
        $curs = oci_new_cursor($con);
        oci_bind_by_name($stid, ":cursor", $curs, -1, OCI_B_CURSOR);
        oci_execute($stid);
        oci_execute($curs);
        return $curs;
}

	if (isset($_SESSION["user_name"])) {
        include("../controller/connection.php");
		
        $curs = getAlacsonypadlos($con);
        $count=0;
        echo '<table>
		<thead>
		<tr>
			<th colspan="6" class="table_header">Alacsonypadlós szerelvények:</th>
		</tr>
		<tr>
			<th class="table_header">Szerelvény neve</th>
			<th class="table_header">Gyártási év</th>
			<th class="table_header">Kapacitása</th>
			<th class="table_header">Meghajtása</th>
			<th class="table_header">Kerékpár<br>helyek száma</th>
            <th class="table_header">Osztály</th>
		</tr>
		</thead>
		<tbody>';
        while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
            //echo $row['SZNEV'];
            $sznev = $row['SZNEV'];
			$gyartasi_ev = $row['GYARTASI_EV'];
			$kapacitas = $row['KAPACITAS'];
			$meghajtas = $row['MEGHAJTAS'];
			$kerekpar = $row['KEREKPARHELYEK_SZAMA'];
            $osztaly = $row['OSZTALY'];
			$class = $count % 2 == 1 ? 'table_even' : 'table_odd';
			echo '<tr>
			<td class="' . $class . '">' . $sznev . '</td>
			<td class="' . $class . '">' . $gyartasi_ev . '</td>
			<td class="' . $class . '">' . $kapacitas . '</td>
			<td class="' . $class . '">' . $meghajtas . ' </td>
			<td class="' . $class . '">' . $kerekpar . ' </td>
            <td class="' . $class . '">' . $osztaly . ' </td>
			</tr>';
			$count++;
        }
        echo '</tbody></table>';

	
	oci_close($con);
    }
	
	?>

</main>

<footer id="footer" class="unselectable">
	<p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p>
</footer>

</body>

</html>
