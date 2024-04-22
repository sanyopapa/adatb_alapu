<?php
    if(!isset($_SESSION)){session_start();}
    include("connection.php");
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $user_name = $_POST['user-name'];
        $new_pwd=$_POST['new_pwd'];
        $new_pwd_2=$_POST['new_pwd_2'];
        $name = $_POST['nev'];
        $age = $_POST['eletkor'];
        $discount_type = $_POST['kedvezmenytipus'];
        $id_number = $_POST['igazolvanyszam'];

        $problems = array();

        if(is_numeric($user_name)){
            $problems['user_name'] = 'A felhasználónévnek betűt kell tartalmaznia.';
        }
        if(strlen($new_pwd)<6 and strlen($new_pwd)>0){
            $problems['pwd'] = 'Az új jelszónak 6 karakter hosszúnak kell lennie.';
        }
        if($new_pwd!=$new_pwd_2){
            $problems['pwd'] = 'A két jelszó nem egyezhet meg!';
        }
        
        $query = "select * from felhasznalo where email = :user_name";
        $stid = oci_parse($con, $query);
        oci_bind_by_name($stid, ':user_name', $user_name);
        oci_execute($stid);
        if(oci_fetch($stid)){
            $problems['user_name'] = 'Ez a felhasználónév foglalt.';
        }

        if(count($problems)==0){
            
            if (!empty($new_pwd)) {
                $pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
                $query = "UPDATE felhasznalo SET jelszo=:pwd where email=:masid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':pwd', $pwd);
                oci_bind_by_name($stid, ':masid', $_SESSION["masid"]);
                oci_execute($stid);

            }
            
            
            if (!empty($user_name)) {
                $query = "UPDATE felhasznalo SET email=:user_name where email=:masid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':user_name', $user_name);
                oci_bind_by_name($stid, ':masid', $_SESSION["masid"]);
                oci_execute($stid);
                $_SESSION["user_name"] = $user_name;
            }

            if (!empty($name)) {
                $query = "UPDATE felhasznalo SET nev=:name where email=:masid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':name', $name);
                oci_bind_by_name($stid, ':masid', $_SESSION["masid"]);
                oci_execute($stid);
                $_SESSION["name"] = $name;
            }

            if (!empty($age)) {
                $query = "UPDATE felhasznalo SET eletkor=:age where email=:masid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':age', $age);
                oci_bind_by_name($stid, ':masid', $_SESSION["masid"]);
                oci_execute($stid);
                $_SESSION["eletkor"] = $age;
            }

            if (!empty($discount_type)) {
                $query = "UPDATE felhasznalo SET kedvezmenytipus=:discount_type where email=:masid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':discount_type', $discount_type);
                oci_bind_by_name($stid, ':masid', $_SESSION["masid"]);
                oci_execute($stid);
                $_SESSION["kedvezmenytipus"] = $discount_type;
            }

            if (!empty($id_number)) {
                $query = "UPDATE felhasznalo SET igazolvanyszam=:id_number where email=:masid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':id_number', $id_number);
                oci_bind_by_name($stid, ':masid', $_SESSION["masid"]);
                oci_execute($stid);
                $_SESSION["igazolvanyszam"] = $id_number;
            }


            if ($_SESSION["admin"]==1) {
                header("Location: ../view/profilesearch.php");
            }
            else{
                header("Location: ../view/myprofile.php");
            }
            
            oci_close($con);
            die;
        }
        else{
            $_SESSION["message"] = $problems;
            while ($e = current($problems)) {
                $key = key($problems);
                $_SESSION["message"][$key] = $e;
                next($problems);
                echo $key . " " . $e . "<br>";
            }
            //header('location: ../view/profilesearch.php');
            oci_close($con);
            die;
        }
    }
    else{
        oci_close($con);
    }
?>
