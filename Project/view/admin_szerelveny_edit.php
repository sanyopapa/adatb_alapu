<?php
$name = $_POST['name'];
$new_train = $_POST['new_train'];

if (!isset($_SESSION)) {
    session_start();
    
    $sznev_error = "";
    $gyartasi_ev_error = "";
    $meghajtas_error = "";
    $kapacitas_error = "";
    $kerekparhelyek_szama_error = "";
    $osztaly_error = "";
    $sikeres = "";

    if (isset($_SESSION["message"])) {
        $keys = array_keys($_SESSION["message"]);
        for ($i = 0; $i < count($_SESSION["message"]); $i++) {
            if ($keys[$i] == 'sznev') {
                $sznev_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'gyartasi_ev') {
                $gyartasi_ev_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'meghajtas') {
                $meghajtas_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'kapacitas') {
                $kapacitas_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'kerekparhelyek_szama') {
                $kerekparhelyek_szama_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'osztaly') {
                $osztaly_error .= $_SESSION["message"][$keys[$i]] . ' ';
            }
            if ($keys[$i] == 'sikeres') {
                $sikeres .= $_SESSION["message"][$keys[$i]] . ' ';
            }
        }

        // Az üzenetek elérését követően állítsuk őket nullára, hogy ne maradjanak a rendszerben tartósan.
        unset($_SESSION["message"]);
    }
}
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
    <title>R150 - Szerelvény módosítás</title>
</head>

<body>
    <nav>
        <?php include 'navbar.php' ?>
    </nav>

    <?php
    include("../controller/functions.php");

    if (isset($_SESSION["user_name"])) {
        if ($_SESSION["admin"] == 1 && $new_train == "false") {
            echo '<main class="torzs table_div">';
            $query = "SELECT * from szerelveny where sznev = :name";

            include("../controller/connection.php");
            $stmt = oci_parse($con, $query);
            oci_bind_by_name($stmt, ":name", $name);
            $ja = oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            $id = $row;
            echo '
            <div class="text1">
                <h1>Szerelvény módosítása:</h1>
            </div>';

            $_SESSION["trainid"] = $name;
            echo '<br><form id="form-login" action="../controller/szerelveny_edit_check.php" method="POST">
            <fieldset class="form_2">
                <legend>' . $id['SZNEV'] . '</legend>';

            if (strlen($gyartasi_ev_error) > 0) {
                echo '<div class="warning">';
                echo $gyartasi_ev_error;
                echo "</div>";
            }

            echo '<input type="hidden" id="train-id" name="train-id" size="25" placeholder=" ' . $name . '"><br>';

            if (strlen($meghajtas_error) > 0) {
                echo '<div class="warning">';
                echo $meghajtas_error;
                echo "</div>";
            }

            if (!empty($id)) {
                echo '<label for="sznev">Szerelvény neve:<br>(nem változtatható)</label>
                    <input type="text" class="train_input" id="sznev" name="sznev" value="' . $id['SZNEV'] . '" readonly>
                    <br>

                    <label for="gyartasi_ev">Gyártási év:</label>
                    <input type="text" class="train_input" id="gyartasi_ev" name="gyartasi_ev" value="' . $id['GYARTASI_EV'] . '">
                    <br>

                    <label for="meghajtas">Meghajtás:</label>
                    <input type="text" class="train_input" id="meghajtas" name="meghajtas" value="' . $id['MEGHAJTAS'] . '">
                    <br>

                    <label for="kapacitas">Kapacitás:</label>
                    <input type="text" class="train_input" id="kapacitas" name="kapacitas" value="' . $id['KAPACITAS'] . '">
                    <br>

                    <label for="kerekparhelyek_szama">Kerékpárhelyek száma:</label>
                    <input type="text" class="train_input" id="kerekparhelyek_szama" name="kerekparhelyek_szama" value="' . $id['KEREKPARHELYEK_SZAMA'] . '">
                    <br>

                    <label for="osztaly">Osztály:</label>
                    <input type="text" class="train_input" id="osztaly" name="osztaly" value="' . $id['OSZTALY'] . '">
                    <br>';
            }

            echo '<input type="reset" name="btn-reset" value="Visszaállítás"><br>
            <input type="submit" name="btn-submit"  value="Küldés"><br>
            </form>

            <form id="form-login" action="../controller/delete_szerelveny.php" method="POST">
            <input type="hidden" name="sznev" value="' . $name . '">
            <input type="submit" name="btn-delete-user" value="Szerelvény törlés">
            </form><br>
            </fieldset>';
        } elseif ($_SESSION["admin"] == 1 && $new_train == "true") {
    ?>

            <main class="torzs">
                <div class="anti-collapse"></div>

                <div class="form-box">
                    <form id="form-login" action="../controller/new_szerelveny_check.php" method="POST">
                        <fieldset class="form_2">
                            <legend>Szerelvény létrehozása</legend>

                            <?php
                            if (strlen($sznev_error) > 0) {
                                echo '<div class="warning">';
                                echo $sznev_error;
                                echo "</div>";
                            }
                            ?>

                            <label for="sznev">Szerelvény neve:</label>
                            <input type="text" class="train_input" id="sznev" name="sznev">
                            <br>

                            <?php
                            if (strlen($gyartasi_ev_error) > 0) {
                                echo '<div class="warning">';
                                echo $gyartasi_ev_error;
                                echo "</div>";
                            }
                            ?>

                            <label for="gyartasi_ev">Gyártási év:</label>
                            <input type="text" class="train_input" id="gyartasi_ev" name="gyartasi_ev">
                            <br>

                            <?php
                            if (strlen($meghajtas_error) > 0) {
                                echo '<div class="warning">';
                                echo $meghajtas_error;
                                echo "</div>";
                            }
                            ?>

                            <label for="meghajtas">Meghajtás:</label>
                            <input type="text" class="train_input" id="meghajtas" name="meghajtas">
                            <br>

                            <?php
                            if (strlen($kapacitas_error) > 0) {
                                echo '<div class="warning">';
                                echo $kapacitas_error;
                                echo "</div>";
                            }
                            ?>

                            <label for="kapacitas">Kapacitás:</label>
                            <input type="text" class="train_input" id="kapacitas" name="kapacitas">
                            <br>

                            <?php
                            if (strlen($kerekparhelyek_szama_error) > 0) {
                                echo '<div class="warning">';
                                echo $kerekparhelyek_szama_error;
                                echo "</div>";
                            }
                            ?>

                            <label for="kerekparhelyek_szama">Kerékpárhelyek száma:</label>
                            <input type="text" class="train_input" id="kerekparhelyek_szama" name="kerekparhelyek_szama">
                            <br>

                            <?php
                            if (strlen($osztaly_error) > 0) {
                                echo '<div class="warning">';
                                echo $osztaly_error;
                                echo "</div>";
                            }
                            ?>

                            <label for="osztaly">Osztály:</label>
                            <input type="text" class="train_input" id="osztaly" name="osztaly">
                            <br>

                            <input class="submit-button" type="submit" name="btn-submit" value="Létrehozás">
                        </fieldset>
                    </form>
                </div>
            </main>

    <?php
        } else {
            header("Location: szerelvenysearch.php");
        }
    }
    ?>
</body>

</html>
