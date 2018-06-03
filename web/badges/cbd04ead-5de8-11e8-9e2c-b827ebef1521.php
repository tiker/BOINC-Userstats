<?php

	// Milkyway@Home
	
	function GetBadges() {
		$sProjectID = "cbd04ead-5de8-11e8-9e2c-b827ebef1521";  // Assigned project UUID (don't change this)
		$iDBSchemaMinVer = 2;	// Minimum version of the database schema required
		$sStatsFile = "stats/user.gz";  // File to parse for stats
		$sDelay = "+48 hours";  // Don't run more than once every ...

		include "/var/www/html/settings/boinc_db_connect.php";

		// Make sure database supports this script
		$oResults = mysqli_query($db_conn, "SELECT value FROM settings WHERE `key` = 'db_schema';");
		while ($sValue = mysqli_fetch_assoc($oResults)) {
			$iDBSchemaVer = $sValue["value"];
		}
		if ($iDBSchemaVer < $iDBSchemaMinVer) {
			echo "Database schema needs to be updated.";
			return 0;
		}
		
		$iCurrentTime = time();

		$oResults = mysqli_query($db_conn, "SELECT badge_lastupdate FROM project_data WHERE uuid = unhex(replace('" . $sProjectID . "','-',''));");
		while ($sValue = mysqli_fetch_assoc($oResults)) {
			$iLastUpdate = $sValue["badge_lastupdate"];
		}


		if ($iCurrentTime < (strtotime($sDelay, $iLastUpdate))) {
			// It hasn't been more than $sDelay hours, abort.
			return false;
		}

		$sQuery = "SELECT account_number, project_url, update_badges FROM project_configuration WHERE uuid = unhex(replace('" . $sProjectID . "','-',''));";
		$oResults = mysqli_query($db_conn, $sQuery);
		
		while ($sValue = mysqli_fetch_assoc($oResults)) {
			$sProjectURL = $sValue["project_url"];
			$iAccountNumber = $sValue["account_number"];
			$bUpdateBadges = $sValue["update_badges"];
		}

		$sStatsURL=$sProjectURL . $sStatsFile;
		$fp = gzopen($sStatsURL, "r");

		while ($fp && !feof($fp)) {
			$line=fgets($fp);

			if (preg_match('/<id>([0-9]+)<\/id>/',$line,$ida) > 0) {
				if ($ida[1] == $iAccountNumber) {
					while (preg_match('/<\/user>/',$line) < 1) {
						$line=fgets($fp);
						if (preg_match('/<create_time>(.*)<\/create_time>/',$line,$ct) > 0) {
							$iCreateTime=$ct[1];
						} elseif (preg_match('/<total_credit>(.*)<\/total_credit>/',$line,$tc) > 0) {
							$total_credit=$tc[1];
						}
					}
					$fp = FALSE;
					
				}
			}
		}

		// ===== Badges earned by credits =====

		$aBadgesCredit = array(
			// Total number of credits that give a badge, high to low
			10000000000,
			5000000000,
			3000000000,
			2000000000,
			1000000000,
			500000000,
			300000000,
			200000000,
			100000000,
			50000000,
			30000000,
			20000000,
			10000000,
			5000000,
			3000000,
			2000000,
			1000000,
			500000,
			100000,
			10000,
			100
		);
		
		$aBadgesCreditUUID = array(
			// UUID for badges
			"81996f41-6605-11e8-9e2c-b827ebef1521",	// 10000000000
			"96d9d357-6605-11e8-9e2c-b827ebef1521",	// 5000000000
			"9fb8d26a-6605-11e8-9e2c-b827ebef1521",	// 3000000000
			"a48ca6a1-6605-11e8-9e2c-b827ebef1521",	// 2000000000
			"a7b748ca-6605-11e8-9e2c-b827ebef1521",	// 1000000000
			"af4fa733-6605-11e8-9e2c-b827ebef1521",	// 500000000
			"bb2b920c-6605-11e8-9e2c-b827ebef1521",	// 300000000
			"be9ddce8-6605-11e8-9e2c-b827ebef1521",	// 200000000
			"c19147eb-6605-11e8-9e2c-b827ebef1521",	// 100000000
			"c42f7d26-6605-11e8-9e2c-b827ebef1521",	// 50000000
			"c7a0a3ae-6605-11e8-9e2c-b827ebef1521",	// 30000000
			"41950f9e-6606-11e8-9e2c-b827ebef1521",	// 20000000
			"44c9970b-6606-11e8-9e2c-b827ebef1521",	// 10000000
			"49350ce4-6606-11e8-9e2c-b827ebef1521",	// 5000000
			"4d744817-6606-11e8-9e2c-b827ebef1521",	// 3000000
			"50cfc811-6606-11e8-9e2c-b827ebef1521",	// 2000000
			"553ef402-6606-11e8-9e2c-b827ebef1521",	// 1000000
			"881c2fbd-6606-11e8-9e2c-b827ebef1521",	// 500000
			"8bff3deb-6606-11e8-9e2c-b827ebef1521",	// 100000
			"8f493125-6606-11e8-9e2c-b827ebef1521",	// 10000
			"92665fcf-6606-11e8-9e2c-b827ebef1521"	// 100
		);

		$iBadges = count($aBadgesCredit);

		for ($i = 0; $i < $iBadges; $i++) {
			if ($total_credit > $aBadgesCredit[$i]) {
				$sQuery = "INSERT INTO badges (badge_uuid, project_uuid, awarded) ";
				$sQuery = $sQuery . "VALUES (unhex(replace('" . $aBadgesCreditUUID[$i] . "','-','')), unhex(replace('" . $sProjectID . "','-','')), true) ";
				$sQuery = $sQuery . "ON DUPLICATE KEY UPDATE awarded=true;";
				mysqli_query($db_conn,$sQuery);
			}
		}
		
		// ===== Badges earned by "Years of Service" =====

		$aBadgesYears = array(
			10,		// Iridium
			9,		// Iridium
			8,		// Platinum
			7,		// Platinum
			6,		// Gold
			5,		// Gold
			4,		// Silver
			3,		// Silver
			2,		// Bronze
			1		// Bronze
		);
		
		$aBadgesYearsUUID = array(
			// UUID for badges
			"08429d01-6660-11e8-9e2c-b827ebef1521",	// 10
			"4c0735ca-6660-11e8-9e2c-b827ebef1521",	// 9
			"4fd52284-6660-11e8-9e2c-b827ebef1521",	// 8
			"54decc29-6660-11e8-9e2c-b827ebef1521",	// 7
			"584020c4-6660-11e8-9e2c-b827ebef1521",	// 6
			"5c0eb384-6660-11e8-9e2c-b827ebef1521",	// 5
			"5f72a937-6660-11e8-9e2c-b827ebef1521",	// 4
			"642b5835-6660-11e8-9e2c-b827ebef1521",	// 3
			"685176c2-6660-11e8-9e2c-b827ebef1521",	// 2
			"6bf10075-6660-11e8-9e2c-b827ebef1521"	// 1
		);
		
		$iBadges = count($aBadgesYears);

		for ($i = 0; $i < $iBadges; $i++) {
			if ($iCurrentTime > (strtotime("+" . $aBadgesYears[$i] . " years", $iCreateTime))) {
				$sQuery = "INSERT INTO badges (badge_uuid, project_uuid, awarded) ";
				$sQuery = $sQuery . "VALUES (unhex(replace('" . $aBadgesYearsUUID[$i] . "','-','')), unhex(replace('" . $sProjectID . "','-','')), true) ";
				$sQuery = $sQuery . "ON DUPLICATE KEY UPDATE awarded=true;";
				mysqli_query($db_conn,$sQuery);
			}
		}

		// ===== Badges - "Special Contribution Badge" =====
		// No idea what this is for or how to determine if someone has it - TODO
		// For now, set to true if we own it.
		
		$bBadgesSpecialContribution = false;	// set to true if we have it
		$bBadgesSpecialContributionUUID = "f06fccec-6661-11e8-9e2c-b827ebef1521";
		
		if ($bBadgesSpecialContribution) {
			$sQuery = "INSERT INTO badges (badge_uuid, project_uuid, awarded) ";
			$sQuery = $sQuery . "VALUES (unhex(replace('" . $bBadgesSpecialContributionUUID . "','-','')), unhex(replace('" . $sProjectID . "','-','')), true) ";
			$sQuery = $sQuery . "ON DUPLICATE KEY UPDATE awarded=true;";
			mysqli_query($db_conn,$sQuery);
		}
		
		// Clean up time

		$sQuery = "INSERT INTO project_data (badge_lastupdate, uuid) ";
		$sQuery = $sQuery . "VALUES (" . $iCurrentTime . ", unhex(replace('" . $sProjectID . "','-','')), true) ";
		$sQuery = $sQuery . "ON DUPLICATE KEY UPDATE badge_lastupdate=" . $iCurrentTime . ";";
		mysqli_query($db_conn,$sQuery);
		
		return true;
	}
?>