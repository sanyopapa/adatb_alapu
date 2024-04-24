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
  <link rel="stylesheet" href="../styles/animation.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/media_size.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/footer.css?v=<?php echo time(); ?>">
  <link rel="icon" href="../img/150_tablogo.png?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="../styles/form.css?v=<?php echo time(); ?>">
  <title>Összes járat az állomáson</title>
</head>
<body>
<nav>
		<?php include 'navbar.php' ?>
	</nav>
  <main class="torzs table_div">
  <div class="text1"><h1>Összes járat az állomáson</h1></div>
  <form id="form-login" class="login-link" action="osszes_jarat.php" method="post">
    <fieldset class="form_2">
      <legend>Állomás keresése</legend>
        <input type="text" name="station" placeholder="Állomás neve">
        <br><input type="submit" name="submit" value="Keresés">
    </fieldset>
  
</form><br>
  
  <?php
    if(isset($_POST['submit'])){ 
      include("../controller/connection.php");
      $station = '';
      if(isset($_POST['station'])){
        $station = $_POST['station'];
      }
      $sql = "SELECT 
              Jarat.Vonatszam, 
              Jarat.Vonattipus, 
              Jarat.Honnan, 
              Jarat.Hova, 
              Kozlekedik.Erkezes
              Kozlekedik.Indulas
              FROM 
              Jarat
              JOIN 
              Kozlekedik ON Jarat.Vonatszam = Kozlekedik.Vonatszam
              WHERE 
              Kozlekedik.AllomasNev = '$station'";
      $statement = oci_parse($con, $sql);
      oci_execute($statement);
      if(!oci_fetch($statement)){
        echo "<p>Nincs ilyen állomás a rendszerben!</p>";
      }
      else {
        $statement = oci_parse($con, $sql);
        oci_execute($statement);
        echo '<table>
        <thead>
        <tr>
          <th class="table_header">Vonatszám</th>
          <th class="table_header">Vonattípus</th>
          <th class="table_header">Honnan</th>
          <th class="table_header">Hova</th>
          <th class="table_header">Menetidő</th>
          <th class="table_header">Indulási idő</th>
        </tr>
      </thead>
      <tbody>';
      $count = 0;

        while($row = oci_fetch_assoc($statement)){
          $class = $count % 2 == 1 ? 'table_even' : 'table_odd';
          $dateTime = date_create_from_format('d-M-y h.i.s.u A', $row['MENETIDO']);
          $formattedDate = date_format($dateTime, 'H:i');
          $dateTime2 = date_create_from_format('d-M-y h.i.s.u A', $row['INDULASI_IDO']);
          $formattedDate2 = date_format($dateTime2, 'H:i');
          echo "<tr>";
            echo '<td class="' . $class . '">' . $row['VONATSZAM'] . '</td>';
            echo '<td class="' . $class . '">' . $row['VONATTIPUS'] . '</td>';
            echo '<td class="' . $class . '">' . $row['HONNAN'] . '</td>';
            echo '<td class="' . $class . '">' . $row['HOVA'] . '</td>';
            echo '<td class="' . $class . '">' . $formattedDate . '</td>';
            echo '<td class="' . $class . '">' . $formattedDate2 . '</td>';
            echo '</tr>';
            $count++;
          
        }
      }
      
      
    }
  ?>
</tbody>
  </table>
</main>
</body>
</html>