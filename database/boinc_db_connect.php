<?php
	$dbname="db_name";
	$dbhost="localhost";
	$dbuser="db_user";
	$dbpass="db_passwd";
	$db_conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	
	$db_conn_status = "";
	$connErrorTitle ="";
	$connErrorDescription = "";
	if (!$db_conn) {
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es konnte keine Verbindung zur Datenbank aufgebaut werden.</br>
					Bitte überprüfe deine Zugangsdaten.";
			include "./errordocs/db_initial_err.php";
			exit();
	}

	$result = mysqli_query($db_conn, "SELECT * FROM boinc_user LIMIT 1");
	$rowCountResult = mysqli_num_rows($result);
	if ($rowCountResult < 1) {
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden noch keine Benutzerdaten eingepflegt.</br>
			Bitte trage die Daten in der Tabelle boinc_user ein.";
		include "./errordocs/db_initial_err.php";
		exit();
	}

	$result = mysqli_query($db_conn, "SELECT * FROM boinc_grundwerte LIMIT 1");
	$rowCountResult = mysqli_fetch_assoc($result);
	if ($rowCountResult < 1) {
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Du hast noch keine Projekte eingepflegt.</br>
		Bitte trage deine Projektdaten in die Tabelle boinc_grundwerte ein.";
		include "./errordocs/db_initial_err.php";
		exit();
	}

	$result = mysqli_query($db_conn, "SELECT * FROM boinc_werte LIMIT 1");
	$rowCountResult = mysqli_fetch_assoc($result);
	if ($rowCountResult < 1) {
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden noch keine Daten abgerufen.</br>
		Bitte warte bis der erste erfolgreiche Datenabruf durchgeführt wurde.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
?>
