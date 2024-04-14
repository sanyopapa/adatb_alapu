<?php
$upload_tmp_dir = "tmp/";

  if (isset($_FILES["profile-pic"])) {
    // csak JPG, JPEG és PNG kiterjesztésű képeket szeretnénk engedélyezni a feltöltéskor
    $engedelyezett_kiterjesztesek = ["jpg", "jpeg", "png"];

    // a feltöltött fájl kiterjesztésének lekérdezése
    $kiterjesztes = strtolower(pathinfo($_FILES["profile-pic"]["name"], PATHINFO_EXTENSION));

    // ha a fájl kiterjesztése szerepel az engedélyezett kiterjesztések között...
    if (in_array($kiterjesztes, $engedelyezett_kiterjesztesek)) {
      // ha a fájl feltöltése sikeresen megtörtént...
      if ($_FILES["profile-pic"]["error"] === 0) {
        // ha a fájlméret nem nagyobb 30 MB-nál...
        if ($_FILES["profile-pic"]["size"] <= 31457280) {
          // a cél útvonal összeállítása
          $cel = "images/" . $_FILES["profile-pic"]["name"];
          // ha már létezik ilyen nevű fájl a cél útvonalon, figyelmeztetést írunk ki
          if (file_exists($cel)) {
            echo "<strong>Figyelem:</strong> A régebbi fájl felülírásra kerül! <br/>";
          }
          // a fájl átmozgatása a cél útvonalra
          if (move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $cel)) {
            echo "Sikeres fájlfeltöltés! <br/>";
          } else {
            echo "<strong>Hiba:</strong> A fájl átmozgatása nem sikerült! <br/>";
          }
        } else {
          echo "<strong>Hiba:</strong> A fájl mérete túl nagy! <br/>";
        }
      } else {
        echo "<strong>Hiba:</strong> A fájlfeltöltés nem sikerült! <br/>";
      }
    } else {
      echo "<strong>Hiba:</strong> A fájl kiterjesztése nem megfelelő! <br/>";
    }
  }
?>