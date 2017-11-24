<?php 
	date_default_timezone_set('UTC');
			if( !ini_get('safe_mode') ){ 
				set_time_limit(120); 
			} 
	include "/path/to/boinc_db_connect.php";

	$query=mysqli_query($db_conn,"SELECT * FROM boinc_grundwerte WHERE project_status = 1;") or die (mysqli_error());

	$total_credits_day = "0";
	$pending_credits = "0";
	$gesamtcredits_h = "0";
	$gesamt_pendings_h = "0";
	$unixtime = time();

	$ctx = stream_context_create(array(
			'http' => array(
				'timeout' => 10
			)
		)
	);

	$updatestarttime = time();

	$sqlupdatestarttime = "UPDATE boinc_user 
	SET lastupdate_start='" .$updatestarttime. "'";
	mysqli_query($db_conn,$sqlupdatestarttime);
	
	while($row=mysqli_fetch_assoc($query))
	{
		$xml_string_pendings = FALSE;
		$xml_string_pendings = @file_get_contents ($row['url'] . "pending.php?format=xml&authenticator=" . $row['authenticator'], 0, $ctx);
		if ($xml_string_pendings == FALSE) {
			$pending_credits = $row['pending_credits'];
		} 
		else {
			$xml_pendings = @simplexml_load_string($xml_string_pendings);
			$pending_credits = intval($xml_pendings->total_claimed_credit);
		}
		$xml_string = FALSE;
		$xml_string = @file_get_contents ($row['url'] . "show_user.php?userid=" . $row['project_userid'] . "&format=xml", 0, $ctx); //WebRPC-Daten fuer jedes aktive Projekt abrufen
		$xml = @simplexml_load_string($xml_string);
		
		if($xml_string == FALSE || intval($xml->total_credit)==0) {
			$total_credits = $row['total_credits'];
			$timestamp = ceil($unixtime/3600) * 3600;
			$diff1h = 0;
		}
		else {
			$total_credits = intval($xml->total_credit);
			$timestamp = ceil($unixtime/3600) * 3600;
			$diff1h = $total_credits - $row['total_credits'];
			$gesamtcredits_h = $gesamtcredits_h + $diff1h;
		}
		if ($diff1h > 0) {
			$sql= "INSERT boinc_werte 
			(project_shortname, time_stamp, credits) 
			VALUES 
			('" .$row['project_shortname']. "', '" .$timestamp. "','" .$diff1h. "')";
			mysqli_query($db_conn,$sql);
		}
		
		$sql = "UPDATE boinc_grundwerte 
		SET total_credits='" .$total_credits. "' 
		WHERE project_shortname='" .$row['project_shortname']. "'";
		mysqli_query($db_conn,$sql);
		
		$sql_pendings = "UPDATE boinc_grundwerte 
		SET pending_credits='" .$pending_credits. "' 
		WHERE project_shortname='" .$row['project_shortname']. "'";
		mysqli_query($db_conn,$sql_pendings); 
		
		$timestamp = date('Y-m-d H').':00:00';
		if ($timestamp == date('Y-m-d'). ' 00:00:00') {
			$time_stamp = ceil($unixtime/3600) * 3600;	
			$sql= "INSERT INTO boinc_werte_day (project_shortname, time_stamp, total_credits, pending_credits) 
			VALUES
			('" .$row['project_shortname']. "', '" .$time_stamp. "', ".$total_credits.", ".$pending_credits.")";
			mysqli_query($db_conn,$sql);
		}
	}

	if ($gesamtcredits_h > 0) {
		$time_stamp = ceil($unixtime/3600) * 3600;
		$sql= "INSERT boinc_werte 
		(project_shortname, time_stamp, credits) 
		VALUES 
		('gesamt', '" .$time_stamp. "','" .$gesamtcredits_h. "')";
		mysqli_query($db_conn,$sql);
	}
	
	$timestamp = date('Y-m-d H').':00:00';
	if ($timestamp == date('Y-m-d'). ' 00:00:00') {
		$gesamt_gestern_query = "SELECT sum(total_credits) AS total_credits FROM boinc_grundwerte";
		$gesamt = mysqli_query($db_conn,$gesamt_gestern_query);
		$gesamt_vortag = mysqli_fetch_assoc($gesamt);
		$total_credits_gestern = $gesamt_vortag['total_credits'];

		$pending_gestern_query = "SELECT sum(pending_credits) AS pending_credits FROM boinc_grundwerte";
		$pendings = mysqli_query($db_conn,$pending_gestern_query);
		$pendings_vortag = mysqli_fetch_assoc($pendings);
		$total_pendings_gestern = $pendings_vortag['pending_credits'];

		$time = ceil($unixtime/3600) * 3600;
		$sql_gesamt= "INSERT INTO boinc_werte_day (project_shortname, time_stamp, total_credits, pending_credits) 
		VALUES ('gesamt', '" .$time. "', '" .$total_credits_gestern. "', '" .$total_pendings_gestern. "')";
		mysqli_query($db_conn,$sql_gesamt);
	}
	
	$updatetime = time();
	$sqlupdatetime = "UPDATE boinc_user 
	SET lastupdate='" .$updatetime. "'";
	mysqli_query($db_conn,$sqlupdatetime);
?>
