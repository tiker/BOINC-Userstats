<?php 
	#include "/path/to/boinc_db_connect.php";

	if( !ini_get('safe_mode') ){ 
		set_time_limit(120); 
	}

	$total_credits_day = "0";
	$pending_credits = "0";
	$total_credits_hour = "0";

	// Set your midnight here. 
	// This is used for setting daylie total and pending credits to the values of midnight for your timezone for the total charts
	// ----------------------------------------------
	// Setze hier den Zeitpunkt von Mitternacht. 
	// Dies wird für die Berechnung der Werte für die Gesamt- und Pending Credits eines Tages in deiner Zeitzone benötigt, welche in den Gesamt-Charts dargestellt wird
	date_default_timezone_set('Europe/Berlin'); 
	$isMidnight = false;
	$timestamp_timezone = date('Y-m-d H').':00:00';
	if ($timestamp_timezone == date('Y-m-d'). ' 00:00:00') {
		$isMidnight = true;
	}

	$ctx = stream_context_create(array(
			'http' => array(
				'timeout' => 10
			)
		)
	);

	//do NOT change this timezone setting
	//Diese Zeitzoneneinstellung NICHT verändern
	date_default_timezone_set('UTC'); 

	$unixtime = time();
	$timestamp_hour = ceil($unixtime/3600) * 3600;

	$sqlupdatestarttime = "UPDATE boinc_user SET lastupdate_start='" .$unixtime. "'";
	mysqli_query($db_conn,$sqlupdatestarttime);

	$query=mysqli_query($db_conn,"SELECT * FROM boinc_grundwerte WHERE project_status = 1;") or die (mysqli_error());	
	while($row=mysqli_fetch_assoc($query))
	{
		$xml_string = FALSE;
		$xml_string = @file_get_contents ($row['url'] . "show_user.php?userid=" . $row['project_userid'] . "&format=xml", 0, $ctx);
		$xml = @simplexml_load_string($xml_string);
		
		if($xml_string == FALSE || intval($xml->total_credit)==0) {
			$total_credits = $row['total_credits'];
			$diff1h = 0;
		}
		else {
			$total_credits = intval($xml->total_credit);
			$diff1h = $total_credits - $row['total_credits'];
			$total_credits_hour = $total_credits_hour + $diff1h;
		}
		if ($diff1h > 0) {
			$sql= "INSERT boinc_werte (project_shortname, time_stamp, credits) 
			VALUES ('" .$row['project_shortname']. "', '" .$timestamp_hour. "','" .$diff1h. "')";
			mysqli_query($db_conn,$sql);
		}
		
		$sql = "UPDATE boinc_grundwerte 
		SET total_credits='" .$total_credits. "' WHERE project_shortname='" .$row['project_shortname']. "'";
		mysqli_query($db_conn,$sql);
		
		if ($isMidnight) {
			$sql= "INSERT INTO boinc_werte_day (project_shortname, time_stamp, total_credits, pending_credits) 
			VALUES ('" .$row['project_shortname']. "', '" .$timestamp_hour. "', ".$total_credits.", ".$pending_credits.")";
			mysqli_query($db_conn,$sql);

			// automatic update of pending credits only on midnight. manual update can be done by using pendings.php
			// Die Pending Credits werden automatisiert nur einmal um Mitternacht aktualisiert. Ein manuelles Update kann jederzeit über die pendings.php erfolgen
			$xml_string_pendings = FALSE;
			$xml_string_pendings = @file_get_contents ($row['url'] . "pending.php?format=xml&authenticator=" . $row['authenticator'], 0, $ctx);
			if ($xml_string_pendings == FALSE) {
				$pending_credits = $row['pending_credits'];
			} 
			else {
				$xml_pendings = @simplexml_load_string($xml_string_pendings);
				$pending_credits = intval($xml_pendings->total_claimed_credit);
			}

			$sql_pendings = "UPDATE boinc_grundwerte SET pending_credits='" .$pending_credits. "' WHERE project_shortname='" .$row['project_shortname']. "'";
			mysqli_query($db_conn,$sql_pendings); 
		}
	}

	if ($total_credits_hour > 0) {
		$sql= "INSERT boinc_werte (project_shortname, time_stamp, credits) 
		VALUES ('gesamt', '" .$timestamp_hour. "','" .$total_credits_hour. "')";
		mysqli_query($db_conn,$sql);
	}
	
	if ($isMidnight) {
		$querySumTotalCredits = "SELECT sum(total_credits) AS total_credits FROM boinc_grundwerte";
		$gesamt = mysqli_query($db_conn,$querySumTotalCredits);
		$gesamt_vortag = mysqli_fetch_assoc($gesamt);
		$total_credits_gestern = $gesamt_vortag['total_credits'];

		$querySumPendings = "SELECT sum(pending_credits) AS pending_credits FROM boinc_grundwerte";
		$pendings = mysqli_query($db_conn,$querySumPendings);
		$pendings_vortag = mysqli_fetch_assoc($pendings);
		$total_pendings_gestern = $pendings_vortag['pending_credits'];

		$sql_gesamt= "INSERT INTO boinc_werte_day (project_shortname, time_stamp, total_credits, pending_credits) 
		VALUES ('gesamt', '" .$timestamp_hour. "', '" .$total_credits_gestern. "', '" .$total_pendings_gestern. "')";
		mysqli_query($db_conn,$sql_gesamt);
	}
	
	$updateendtime = time();
	$sqlupdateendtime = "UPDATE boinc_user SET lastupdate='" .$updateendtime. "'";
	mysqli_query($db_conn,$sqlupdateendtime);
?>
