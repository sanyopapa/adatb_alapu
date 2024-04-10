

<?php
	$dbhost = "localhost";
	$dbuser = "C##TESZTOLASZCS";
	$dbpass = "C##TESZTOLASZCS";
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
 


	if(!$con =oci_connect('SYSTEM', 'Goldenapple1', $tns,'UTF8'))
	{
		echo "Nem sikerült csatlakozni az adatbázishoz!";
	}
	else
	{
		echo "Sikerült csatlakozni az adatbázishoz!";
	}
?>