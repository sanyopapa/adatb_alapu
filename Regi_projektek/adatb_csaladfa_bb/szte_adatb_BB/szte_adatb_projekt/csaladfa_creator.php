<?php
if(!isset($_SESSION)){session_start();}
include("connection.php");
$nev=$_POST['csalad_neve'];
$id=$_SESSION["id"];
$user_name=$_SESSION["user_name"];
$query= "SELECT nev from csaladfa_sum where nev like ".'"'."%".$nev."%".'"';
$query_result=mysqli_query($con, $query);
if (mysqli_num_rows($query_result)>0) {
    $szam=mysqli_num_rows($query_result)+1;
    $nev=$nev.'_'.$szam;
}
$query = "INSERT into csaladfa_sum (letrehozo_id, letrehozo, nev) values('$id','$user_name','$nev')";
mysqli_query($con, $query);

$tabla_neve=$nev.'_'.$user_name.'_szemelyek';
$tabla_t=$nev.'_'.$user_name.'_szemelyek';

$_SESSION["tabla_neve"]=$tabla_neve;
$query="CREATE TABLE `csaladfa_db`.`$tabla_neve` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'A személy azonosítója' , `nev` VARCHAR(60) NOT NULL COMMENT 'A személy neve' , `nem` VARCHAR(10) NOT NULL COMMENT 'A személy biológiai neme' , `szuletes` DATE NOT NULL COMMENT 'A személy születési dátuma' , `halalozas` DATE NOT NULL COMMENT 'A személy halálozási dátuma' , `anya` VARCHAR(60) NOT NULL COMMENT 'A személy anyjának neve' , `apa` VARCHAR(60) NOT NULL COMMENT 'A személy apjának neve' , PRIMARY KEY (`id`)) ENGINE = InnoDB COMMENT = 'A ".$nev." család személyeit kezelő tábla'";
mysqli_query($con, $query);
$tabla_neve_e=$nev.'_'.$user_name.'_esemenyek';
$query="CREATE TABLE `csaladfa_db`.`$tabla_neve_e` (`id` INT NOT NULL AUTO_INCREMENT COMMENT 'Elsődleges kulcs, az esemény azonosítója' , `szemelyid` INT NOT NULL COMMENT 'Eseményben érintett egyik személy azonosítója', `hazassag_datum` DATE NOT NULL COMMENT 'A házasság dátuma' , `valas_datum` DATE NOT NULL COMMENT 'A válás dátuma (üres is lehet)' , `erintett_id` INT NOT NULL COMMENT 'A másik érintett személy azonosítója' , PRIMARY KEY (`id`)) ENGINE = InnoDB COMMENT = 'A ".$nev." család eseményeit kezelő tábla'";
mysqli_query($con, $query);
$query="ALTER TABLE `$tabla_neve_e` ADD FOREIGN KEY (`szemelyid`) REFERENCES `$tabla_neve`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
mysqli_query($con, $query);
$query="ALTER TABLE `uj_eszti_esemenyek` ADD FOREIGN KEY (`erintett_id`) REFERENCES `uj_eszti_szemelyek`(`id`) ON DELETE CASCADE ON UPDATE CASCADE"
mysqli_query($con, $query);
$tabla_neve_t=$nev.'_'.$user_name.'_testverek';
$query="CREATE TABLE `csaladfa_db`.`$tabla_neve_t` (`szemelyid` INT NOT NULL COMMENT 'A személy azonosítója' , `nev` VARCHAR(60) NOT NULL COMMENT 'A személy testvére' ) ENGINE = InnoDB COMMENT = 'Testvéreket számontartó tábla egy családnál'";
mysqli_query($con, $query);
$query="ALTER TABLE `$tabla_neve_t` ADD FOREIGN KEY (`szemelyid`) REFERENCES `$tabla_neve`(`id`) ON DELETE CASCADE ON UPDATE CASCADE";
mysqli_query($con, $query);
header('location: myprofile.php');
?>