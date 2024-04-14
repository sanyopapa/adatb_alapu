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
            <option value="kozalkalmazott">Közalkalmazott</option>
            <option value="nyugdijas">Nyugdíjas</option>
        </select><br>
        <label for="type">Bérlet típusa:</label><br>
        <select id="type" name="type" required>
            <option value="varmegye">Vármegye</option>
            <option value="orszag">Országbérlet</option>
        </select><br>
        <label for="varmegye">Vármegye (ha vármegye bérletet választott):</label><br>
        <input type="text" id="varmegye" name="varmegye"><br>
        <input type="submit" value="Vásárlás">
    </form>
</body>
</html>