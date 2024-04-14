<?php
    if(!isset($_SESSION)){session_start();}
    include("connection.php");
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $user_name = $_POST['user-name'];
        $pwd=$_POST['pwd'];
        

        $problems = array();

        if(is_numeric($user_name)){
            $problems['user_name'] = 'A felhasználónévnek betűt kell tartalmaznia.';
        }
        if(strlen($pwd)<6 and strlen($pwd)>0){
            $problems['pwd'] = 'Az új jelszónak 6 karakter hosszúnak kell lennie.';
        }

        $query = "select * from fiokok where felhasznalonev = :user_name";
        $stid = oci_parse($con, $query);
        oci_bind_by_name($stid, ':user_name', $user_name);
        oci_execute($stid);
        if(oci_fetch($stid)){
            $problems['user_name'] = 'Ez a felhasználónév foglalt.';
        }

        if(count($problems)==0){
            
            if (!empty($pwd)) {
                $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                $query = "UPDATE fiokok SET jelszo=:pwd where felhasznalonev=:masid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':pwd', $pwd);
                oci_bind_by_name($stid, ':masid', $_SESSION["masid"]);
                oci_execute($stid);
            }
            
            
            if (!empty($user_name)) {
                $query = "UPDATE fiokok SET felhasznalonev=:user_name where felhasznalonev=:masid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':user_name', $user_name);
                oci_bind_by_name($stid, ':masid', $_SESSION["masid"]);
                oci_execute($stid);
            }

            if (empty($mod)) {
                $query = "UPDATE fiokok SET admin=0 WHERE felhasznalonev=:masid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':masid', $_SESSION["masid"]);
                oci_execute($stid);
            } else {
                $query = "UPDATE fiokok SET admin=1 WHERE felhasznalonev=:masid";
                $stid = oci_parse($con, $query);
                oci_bind_by_name($stid, ':masid', $_SESSION["masid"]);
                oci_execute($stid);
            }
            
            header("Location: ../view/myprofile.php");
            oci_close($con);
            die;
        }
        else{
            $_SESSION["message"] = $problems;
            header('location: ../view/profilesearch.php');
            oci_close($con);
            die;
        }
    }
    else{
        oci_close($con);
    }
?>