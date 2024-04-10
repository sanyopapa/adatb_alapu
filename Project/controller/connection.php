

<?php
	$dbhost = "localhost";
	$dbuser = "SYSTEM";
	$dbpass = "Goldenapple1"; //Íde kell a jelszó
	$dbname = "csaladfa_db";
	$tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.0.19)(PORT = 1521)) 
    )
    (CONNECT_DATA =
      (SID = xe)
    )
  )"; 


	if(!$con =oci_connect($dbuser, $dbpass, $tns,'UTF8'))
	{
		echo "Nem sikerült csatlakozni az adatbázishoz!";
	}
	else
	{
		echo "Sikerült csatlakozni az adatbázishoz!";
	}
?>