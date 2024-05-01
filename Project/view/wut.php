<?php
// A megadott dátum
$string_date = "2024-05-01T04:30";
echo $string_date; 
echo "<br>";
// Dátum objektum létrehozása a megadott formátumból
$date = DateTime::createFromFormat("Y-m-d\TH:i", $string_date);
echo $date->format("Y-m-d H:i");
echo "<br>";
// Dátum formázása az Oracle által elfogadott formátumra
$formatted_date = $date->format("YYYY-MM-DD HH24:MI");
echo $formatted_date;
echo "<br>";
// Az Oracle által elfogadott formátum használata
$oracle_date = "'" . $formatted_date . "'";
echo $oracle_date;
?>
