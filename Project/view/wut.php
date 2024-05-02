<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar Overlay</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav class="navbar">
  <ul>
    <li><a href="#">Home</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Contact</a></li>
  </ul>
</nav>

<div class="overlay">
    <?php
    $kerekparhelyek_szama="0";
    if ( !is_numeric($kerekparhelyek_szama)) {
        $problems['kerekparhelyek_szama'] = 'A kerékpárhelyek számát meg kell adni számként!';
    }
    echo $problems['kerekparhelyek_szama'];
    ?>

</div>

<div class="content">
  <h1>Main Content</h1>
  <p>This is the main content area.</p>
</div>

</body>
</html>
