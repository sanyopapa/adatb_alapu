<?php
	if(!isset($_SESSION)){session_start();}
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
    
    <title>R150 Vasútmenetrend - Névjegy</title>
</head>
<body>
<nav>
    <?php include 'navbar.php' ?>
    </nav>

    <header class="container">
        <div class="image">
            <img class="index_pic logo_img" src="../img/150_tablogo.png" alt="Rajz a vonatról">
        </div>
        <div class="text1 ">
            <h1>Névjegy</h1>
        </div>
    </header>
    <main class="torzs table_div">
    
       <p>Ezt a projektet az <strong>R150 csoport</strong> készítette az SZTE <i>Adatbázis alapú rendszerek</i> tárgy gyakorlatának teljesítése céljából.</p>
    
        <table>
            <thead>
                <tr>
                    <th colspan="3" class="table_header">R150 linkjei:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="table_odd">Facebook</td>
                    <td class="table_odd"><a class="blue-link" href="https://facebook.com/railway150" target="_blank">Railway150</a></td>
                </tr>
                <tr>
                    <td class="table_even">Instagram</td>
                    <td class="table_even"><a class="blue-link" href="https://instagram.com/railway150" target="_blank">@railway150</a></td>
                </tr>
            </tbody>
            </table>
            <br>
            <table>
            <thead>
                <tr>
                    <th colspan="3" class="table_header">Stáblista:</th>
                </tr>
            </thead>
            <tbody>
              <tr>
                    <td class="table_even">Fejlesztő:</td>
                    <td class="table_even">Esztebán<br>Rkut<br>Sanyó papa</td>
                    
                </tr>
                <tr>
                    <td class="table_odd">Dizájn:</td>
                    <td class="table_odd">DeeAyDan</td>
                    
                </tr>
                <tr>
                    <td class="table_even">Külön köszönet:</td>
                    <td class="table_even">Internet</td>
                    
                </tr>
                <tr>
                    <td class="table_odd">Hotel:</td>
                    <td class="table_odd">Trivago</td>
                    
                </tr>
               
            </tbody>
            </table>
            <br>
            <table>
            <thead>
                <tr>
                    <th colspan="2" class="table_header">Bevétel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="table_odd">Teljes bevétel</td>
                    <td class="table_odd">
                        <?php
                            include("../controller/connection.php");

                            $query = "SELECT SUM(Jegy.Ar) AS Osszeg
                            FROM Felhasznalo
                            JOIN Vasarol ON Felhasznalo.Email = Vasarol.Email
                            JOIN Jegy ON Vasarol.Tipus = Jegy.Tipus";

                            $statement = oci_parse($con, $query);
                            oci_execute($statement);

                            if (oci_fetch($statement)) {
                                $osszeg = oci_result($statement, "OSSZEG");
                                if($osszeg == null){
                                    echo "0 Ft";
                                }else{
                                    echo "" . $osszeg . " Ft";
                                }
                            }

                            oci_close($con);
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="table_even">Országbérlet</td>
                    <td class="table_even">
                        <?php
                                include("../controller/connection.php");

                                $query = "SELECT SUM(Jegy.Ar) AS Osszeg
                                FROM Felhasznalo
                                JOIN Vasarol ON Felhasznalo.Email = Vasarol.Email
                                JOIN Jegy ON Vasarol.Tipus = Jegy.Tipus
                                WHERE Jegy.Tipus IN ('Teljesárú országbérlet', 'Kedvezményes országbérlet')";

                                $statement = oci_parse($con, $query);
                                oci_execute($statement);

                                if (oci_fetch($statement)) {
                                    $osszeg = oci_result($statement, "OSSZEG");
                                    if($osszeg == null){
                                        echo "0 Ft";
                                    }else{
                                        echo "" . $osszeg . " Ft";
                                    }
                                }

                                oci_close($con);
                            
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="table_odd">Vármegyebérlet</td>
                    <td class="table_odd">
                        <?php
                                include("../controller/connection.php");

                                $query = "SELECT SUM(Jegy.Ar) AS Osszeg
                                FROM Felhasznalo
                                JOIN Vasarol ON Felhasznalo.Email = Vasarol.Email
                                JOIN Jegy ON Vasarol.Tipus = Jegy.Tipus
                                WHERE Jegy.Tipus LIKE 'Teljesárú vármegyebérlet%' OR Jegy.Tipus LIKE 'Kedvezményes vármegyebérlet%'";

                                $statement = oci_parse($con, $query);
                                oci_execute($statement);

                                if (oci_fetch($statement)) {
                                    $osszeg = oci_result($statement, "OSSZEG");
                                    if($osszeg == null){
                                        echo "0 Ft";
                                    }else{
                                        echo "" . $osszeg . " Ft";
                                    }
                                }

                                oci_close($con);
                            
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="table_even">Magyarország24 jegy</td>
                    <td class="table_even">
                        <?php
                                include("../controller/connection.php");

                                $query = "SELECT SUM(Jegy.Ar) AS Osszeg
                                FROM Felhasznalo
                                JOIN Vasarol ON Felhasznalo.Email = Vasarol.Email
                                JOIN Jegy ON Vasarol.Tipus = Jegy.Tipus
                                WHERE Jegy.Tipus = 'Magyarország24 jegy'";

                                $statement = oci_parse($con, $query);
                                oci_execute($statement);

                                if (oci_fetch($statement)) {
                                    $osszeg = oci_result($statement, "OSSZEG");
                                    if($osszeg == null){
                                        echo "0 Ft";
                                    }else{
                                        echo "" . $osszeg . " Ft";
                                    }
                                }

                                oci_close($con);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="table_odd">Vármegyejegy</td>
                    <td class="table_odd">
                        <?php
                                include("../controller/connection.php");

                                $query = "SELECT SUM(Jegy.Ar) AS Osszeg
                                FROM Felhasznalo
                                JOIN Vasarol ON Felhasznalo.Email = Vasarol.Email
                                JOIN Jegy ON Vasarol.Tipus = Jegy.Tipus
                                WHERE Jegy.Tipus LIKE 'Teljesárú Vármegye24 napijegy%' OR Jegy.Tipus LIKE 'Teljesárú Vármegye24 napijegy%'";

                                $statement = oci_parse($con, $query);
                                oci_execute($statement);

                                if (oci_fetch($statement)) {
                                    $osszeg = oci_result($statement, "OSSZEG");
                                    if($osszeg == null){
                                        echo "0 Ft";
                                    }else{
                                        echo "" . $osszeg . " Ft";
                                    }
                                }

                                oci_close($con);
                            
                        ?>
                    </td>
                </tr>
                <tr>
                <td class="table_even">Kedvezményes vásárlásból származó bevétel</td>
                <td class="table_even">
                    <?php
                            include("../controller/connection.php");

                            $query = "SELECT SUM(Jegy.Ar) AS Osszeg
                            FROM Felhasznalo
                            JOIN Vasarol ON Felhasznalo.Email = Vasarol.Email
                            JOIN Jegy ON Vasarol.Tipus = Jegy.Tipus
                            WHERE Felhasznalo.Kedvezmenytipus = 'Diák' OR Felhasznalo.Kedvezmenytipus = 'Nyugdíjas'";

                            $statement = oci_parse($con, $query);
                            oci_execute($statement);

                            if (oci_fetch($statement)) {
                                $osszeg = oci_result($statement, "OSSZEG");
                                if($osszeg == null){
                                    echo "0 Ft";
                                }else{
                                    echo "" . $osszeg . " Ft";
                                }
                            }

                            oci_close($con);
                        
                    ?>
                </td>
                </tr>
                <tr>
                    <td class="table_odd">Teljesárú vásárlásból származó bevétel</td>
                    <td class="table_odd">
                        <?php
                                include("../controller/connection.php");

                                $query = "SELECT SUM(Jegy.Ar) AS Osszeg
                                FROM Felhasznalo
                                JOIN Vasarol ON Felhasznalo.Email = Vasarol.Email
                                JOIN Jegy ON Vasarol.Tipus = Jegy.Tipus
                                WHERE Felhasznalo.Kedvezmenytipus = 'Felnőtt'";

                                $statement = oci_parse($con, $query);
                                oci_execute($statement);

                                if (oci_fetch($statement)) {
                                    $osszeg = oci_result($statement, "OSSZEG");
                                    if($osszeg == null){
                                        echo "0 Ft";
                                    }else{
                                        echo "" . $osszeg . " Ft";
                                    }
                                }

                                oci_close($con);
                            
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="table_even">Kedvezményes országbérletből származó bevétel</td>
                    <td class="table_even ">
                        <?php
                                include("../controller/connection.php");

                                $query = "SELECT SUM(Jegy.Ar) AS Osszeg
                                FROM Felhasznalo
                                JOIN Vasarol ON Felhasznalo.Email = Vasarol.Email
                                JOIN Jegy ON Vasarol.Tipus = Jegy.Tipus
                                WHERE Felhasznalo.Kedvezmenytipus = 'Diák' OR Felhasznalo.Kedvezmenytipus = 'Nyugdíjas' AND Jegy.Tipus IN ('Kedvezményes országbérlet')";

                                $statement = oci_parse($con, $query);
                                oci_execute($statement);

                                if (oci_fetch($statement)) {
                                    $osszeg = oci_result($statement, "OSSZEG");
                                    if($osszeg == null){
                                        echo "0 Ft";
                                    }else{
                                        echo "" . $osszeg . " Ft";
                                    }
                                }

                                oci_close($con);
                            
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="table_odd">Kedvezményes vármegyebérletből származó bevétel</td>
                    <td class="table_odd">
                        <?php
                                include("../controller/connection.php");

                                $query = "SELECT SUM(Jegy.Ar) AS Osszeg
                                FROM Felhasznalo
                                JOIN Vasarol ON Felhasznalo.Email = Vasarol.Email
                                JOIN Jegy ON Vasarol.Tipus = Jegy.Tipus
                                WHERE Felhasznalo.Kedvezmenytipus = 'Diák' OR Felhasznalo.Kedvezmenytipus = 'Nyugdíjas' AND Jegy.Tipus LIKE 'Kedvezményes vármegyebérlet%'";

                                $statement = oci_parse($con, $query);
                                oci_execute($statement);

                                if (oci_fetch($statement)) {
                                    $osszeg = oci_result($statement, "OSSZEG");
                                    if($osszeg == null){
                                        echo "0 Ft";
                                    }else{
                                        echo "" . $osszeg . " Ft";
                                    }
                                }

                                oci_close($con);
                            
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table>
            <thead>
            <tr>
                <th class = "table_header">Kor</th>
                <th class = "table_header">Összesen költött</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include("../controller/connection.php");

            $query = "SELECT F.Eletkor, COALESCE(SUM(J.Ar), 0) AS Osszesen_koltott
            FROM Felhasznalo F
            LEFT JOIN Vasarol V ON F.Email = V.Email
            LEFT JOIN Jegy J ON V.Tipus = J.Tipus
            GROUP BY F.Eletkor";

            $statement = oci_parse($con, $query);
            oci_execute($statement);

            $valtozo = 0;
            while ($row = oci_fetch_assoc($statement)) {
                $kor = $row['ELETKOR'];
                $osszesenKoltott = isset($row['OSZESSEN_KOLTOTT']) ? $row['OSZESSEN_KOLTOTT'] : "0";
                
                if($valtozo % 2 == 0){
                    echo "<tr>";
                    echo "<td class='table_odd'>$kor</td>";
                    echo "<td class='table_odd'>$osszesenKoltott Ft</td>";
                    echo "</tr>";
                }else{
                    echo "<tr>";
                    echo "<td class='table_even'>$kor</td>";
                    echo "<td class='table_even'>$osszesenKoltott Ft</td>";
                    echo "</tr>";
                }
                $valtozo++;
            }
            $valtozo = 0;

            oci_close($con);
            ?>


            </tbody>
        </table>
        </main>
    <footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
</body>
</html>