<?php
    if(!isset($_SESSION)){session_start();}
    $date_error="";
    $same_error="";
    $foglalt="";
    if(isset($_SESSION["message"])){
        $keys = array_keys($_SESSION["message"]);
        for($i=0; $i < count($_SESSION["message"]); $i++) {
            
            if ($keys[$i] == 'same') {
                $same_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'date') {
                $date_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'foglalt') {
                $foglalt .= $_SESSION["message"][$keys[$i]] . ' ';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Bérletvásárlás</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/main_style.css?v=<?php echo time(); ?>">
		<link rel="stylesheet" href="../style/form_style.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="../style/profiles.css?v=<?php echo time(); ?>">
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
<h1>Vonatbérlet vásárlás</h1>
    <form action="berletvasarlas_feldolgozas.php" method="post">
        <label for="name">Név:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="condition">Feltétel:</label><br>
        <select id="condition" name="condition" required>
            <option value="diak">Diák</option>
        </select><br>
        <label for="type">Bérlet típusa:</label><br>
        <select id="type" name="type" required>
            <option value="Kedvezményes">Kedvezményes</option>
            <option value="Teljesarú">Teljesárú</option>
        </select><br>
        <label for="varmegye">Vármegye (ha vármegye bérletet választott):</label><br>
        <input type="text" id="varmegye" name="varmegye"><br>
        <input type="submit" value="Vásárlás">
   </form>
</body>
</html>