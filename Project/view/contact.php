<?php
	if(!isset($_SESSION)){session_start();}
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/page_images.css">
    <link rel="stylesheet" href="../styles/page_content.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/dropdown.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="../styles/media_size.css">
    <link rel="stylesheet" href="../styles/animation.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="icon" href="../img/150_tablogo.png">
    <link rel="icon" href="../img/150_tablogo.png">
    <title>R150 Családfa - Névjegy</title>
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
    <main class="torzs">
       <p>Ezt a projektet az <strong>R150 csoport</strong> készítette az SZTE Adatbázisok tárgy gyakorlatának teljesítése céljából.</p>
    </main>
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
        </main>
    <footer id="footer" class="unselectable">
        <p class="footer-p">A projekt <a href="https://www.reddit.com/r/linuxquestions/comments/r2ka86/where_can_i_find_the_btw_version_of_arch_linux/" target="_blank" id="footer_link"> Github </a> oldala</p> 
    </footer>
</body>
</html>