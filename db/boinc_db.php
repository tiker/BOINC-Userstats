<?
	$dbname="db_name";
	$dbhost="localhost";
	$dbuser="db_user";
	$dbpass="db_passwd";
	$db_conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	
	// Pruefe Connection
	// $db_conn_status = "";
	if (!$db_conn) {
		// Default error handling
		// a. sofort sterben, ist aber blöd, weil niemand erfaehrt warum
		// die();
		// b. Nachricht anzeigen (unverbindlichen Text + ErrNo, keinesfalls Error), zerstört aber Ausgabelayout
		// echo "Failed to connect to MySQL, Error: ". mysqli_connect_errno();
		// c. Default error var bestimmen und in den php's auswerten 
		// $db_conn_status = mysqli_connect_errno()." : ".mysqli_connect_error();
		// d. error logging
		// in error.log
		// error_log(mysqli_connect_errno()." : ".mysqli_connect_error());
		// oder in eigenem log
		// error_log(mysqli_connect_errno()." : ".mysqli_connect_error(), 3, "/var/tmp/error_in_stats.log");
	}
?>
