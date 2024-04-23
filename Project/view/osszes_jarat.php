<?php
    if(!isset($_SESSION)){session_start();}
    include("../controller/connection.php");
    $station = '';
    if(isset($_GET['station'])){
        $station = $_GET['station'];
    }
    $sql = "SELECT * FROM jarat WHERE honnan LIKE '%$station%' OR hova LIKE '%$station%'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>" . $row['vonatszam'] . "</td>";
        echo "<td>" . $row['vonattipus'] . "</td>";
        echo "<td>" . $row['honnan'] . "</td>";
        echo "<td>" . $row['hova'] . "</td>";
        echo "<td>" . $row['menetido'] . "</td>";
        echo "<td>" . $row['indulas'] . "</td>";
        echo "</tr>";
        }
    }
    else {
        echo "<tr><td colspan='6'>Nincs találat az adott állomásnévre.</td></tr>";
    }
    $conn->close();
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
  <h1>Összes járat az állomáson</h1>
  <form action="osszes_jarat.php" method="get">
    <input type="text" name="station" placeholder="Állomás neve">
    <input type="submit" value="Keresés">
  </form>
  <table>
    <thead>
      <tr>
        <th>Vonatszám</th>
        <th>Vonattípus</th>
        <th>Honnan</th>
        <th>Hova</th>
        <th>Menetidő</th>
        <th>Indulási idő</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</body>
</html>