<?php
	$dbname="db_name";
	$dbhost="localhost";
	$dbuser="db_user";
	$dbpass="db_passwd";
	$db_conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	
	// Pruefe Connection
	$db_conn_status = "";
	$connErrorTitle ="";
	$connErrorDescription = "";
	if (!$db_conn) {
		// Default error handling
		// a. sofort sterben, ist aber blöd, weil niemand erfaehrt warum
		// die();
		// b. Nachricht anzeigen (unverbindlichen Text + ErrNo, keinesfalls Error), zerstört aber Ausgabelayout
		// echo "Failed to connect to MySQL, Error: ". mysqli_connect_errno();
		// c. Default error var bestimmen und in den php's auswerten 
		//	$db_conn_status = mysqli_connect_errno()." : ".mysqli_connect_error();
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es konnte keine Verbindung zur Datenbank aufgebaut werden.</br>
					Bitte überprüfe deine Zugangsdaten.";
			include "./errordocs/db_initial_err.php";
			exit();
		// d. error logging
		// in error.log
		//error_log(mysqli_connect_errno()." : ".mysqli_connect_error());
		// oder in eigenem log
		// error_log(mysqli_connect_errno()." : ".mysqli_connect_error(), 3, "/var/tmp/error_in_stats.log");
	}

	// Testen, ob Benutzerdaten eingepflegt wurden
	$result = mysqli_query($db_conn, "SELECT * FROM boinc_user LIMIT 1");
	$rowCountResult = mysqli_num_rows($result);
	if ($rowCountResult < 1) {
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden noch keine Benutzerdaten eingepflegt.</br>
			Bitte trage die Daten in der Tabelle boinc_user ein.";
		include "./errordocs/db_initial_err.php";
		exit();
	}

	// Testen, ob mindestens ein Projekt in der Datenbank eingepflegt wurden
	$result = mysqli_query($db_conn, "SELECT * FROM boinc_grundwerte LIMIT 1");
	$rowCountResult = mysqli_fetch_assoc($result);
	if ($rowCountResult < 1) {
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Du hast noch keine Projekte eingepflegt.</br>
		Bitte trage deine Projektdaten in die Tabelle boinc_grundwerte ein.";
		include "./errordocs/db_initial_err.php";
		exit();
	}

	// Testen, ob bereits Daten von Projekten abgerufen wurden
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
