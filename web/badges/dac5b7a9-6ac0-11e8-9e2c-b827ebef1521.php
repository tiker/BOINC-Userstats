<?php

	// TN-Grid
	
	function GetBadges() {
		$sProjectID = "dac5b7a9-6ac0-11e8-9e2c-b827ebef1521";  // Assigned project UUID (don't change this)
		$iDBSchemaMinVer = 2;	// Minimum version of the database schema required
		$sStatsFile = "stats/badge_user.gz";  // File to parse for stats
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
		$aValue = mysqli_fetch_assoc($oResults);
		$iLastUpdate = $aValue["badge_lastupdate"];

		if ($iCurrentTime < (strtotime($sDelay, $iLastUpdate))) {
			// It hasn't been more than $sDelay hours, abort.
			return false;
		}

		$sQuery = "INSERT INTO project_data (badge_lastupdate, uuid) ";
		$sQuery = $sQuery . "VALUES (" . $iCurrentTime . ", unhex(replace('" . $sProjectID . "','-',''))) ";
		$sQuery = $sQuery . "ON DUPLICATE KEY UPDATE badge_lastupdate=" . $iCurrentTime . ";";
		mysqli_query($db_conn,$sQuery);

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

			$aBadgeID = array();
			if (preg_match('/<user_id>([0-9]+)<\/user_id>/',$line,$ida) > 0) {
				if ($ida[1] == $iAccountNumber) {
					while (preg_match('/<\/badge_user>/',$line) < 1) {
						$line=fgets($fp);
						if (preg_match('/<badge_id>(.*)<\/badge_id>/',$line,$ct) > 0) {
							$aBadgeID[$ct[1]] = true;
						}
					}
				} elseif ($ida[1] > $iAccountNumber) {
					// Badges are in order and we passed our account number so we know we won't find any more badges for us.
					$fp = FALSE;
				}
			}
		}

		if (count($aBadgeID) == 0) {
			// We have no badges, no point in continuing.
			exit();
		}
		
		// ===== Badges earned by credits =====

		$aBadgesIDs = array();
		// Badge ID --- Badge UUID
		$aBadgesIDs[8] = "222659fd-6cee-11e8-9e2c-b827ebef1521";	// 50K (Bronze)
		$aBadgesIDs[12] = "22265a34-6cee-11e8-9e2c-b827ebef1521";	// 100K (Silver)
		$aBadgesIDs[13] = "22265a54-6cee-11e8-9e2c-b827ebef1521";	// 500K (Gold)
		$aBadgesIDs[14] = "22265a70-6cee-11e8-9e2c-b827ebef1521";	// 1M (Amethyst)
		$aBadgesIDs[15] = "22265a8d-6cee-11e8-9e2c-b827ebef1521";	// 2M (Ruby)
		$aBadgesIDs[16] = "22265aa9-6cee-11e8-9e2c-b827ebef1521";	// 5M (Turquoise)
		$aBadgesIDs[17] = "22265ac3-6cee-11e8-9e2c-b827ebef1521";	// 10M (Jade)
		$aBadgesIDs[18] = "22265ae0-6cee-11e8-9e2c-b827ebef1521";	// 20M (Sapphire)
		$aBadgesIDs[19] = "22265afb-6cee-11e8-9e2c-b827ebef1521";	// 50M (Emerald)
		$aBadgesIDs[20] = "6f4f579f-6cb4-11e8-9e2c-b827ebef1521";	// 100M (Diamond)

		// ===== Badges earned by recent average credit for top % =====
		$aBadgesIDs[1] = "6f4f57f3-6cb4-11e8-9e2c-b827ebef1521";	// Top 1% in average credit (Gold)
		$aBadgesIDs[2] = "6f4f57d7-6cb4-11e8-9e2c-b827ebef1521";	// Top 10% in average credit (Silver)
		$aBadgesIDs[3] = "6f4f57bb-6cb4-11e8-9e2c-b827ebef1521";	// Top 25% in average credit (Bronze)

		
		foreach ($aBadgeID as $i => $b) {
			$sQuery = "INSERT INTO badges (badge_uuid, project_uuid, awarded) ";
			$sQuery = $sQuery . "VALUES (unhex(replace('" . $aBadgesIDs[$i] . "','-','')), unhex(replace('" . $sProjectID . "','-','')), true) ";
			$sQuery = $sQuery . "ON DUPLICATE KEY UPDATE awarded=true;";
			mysqli_query($db_conn,$sQuery);
		}

		return true;
	}

	function ShowEarnedBadgesHTML() {
		// Figure out the badges earned so far and return a HTML formatted string to display in a web browser.
		// TODO language (EN / DE / ??) specific ?
		$sProjectID = "dac5b7a9-6ac0-11e8-9e2c-b827ebef1521";  // Assigned project UUID (don't change this)
		$iDBSchemaMinVer = 2;	// Minimum version of the database schema required

		include "/var/www/html/settings/boinc_db_connect.php";
		$sHTMLReturn = "";

		$sQuery = "SELECT HEX(badge_uuid) FROM badges WHERE project_uuid = unhex(replace('" . $sProjectID . "','-','')) AND awarded = 1;";
		$oResults = mysqli_query($db_conn, $sQuery);
		$aBadges = array();

		while ($sValue = mysqli_fetch_assoc($oResults)) {
			$hBadgeUUID = $sValue["HEX(badge_uuid)"];
			$sBadgeUUID = substr($hBadgeUUID, 0, 8). "-" . substr($hBadgeUUID, 8, 4) . "-" . substr($hBadgeUUID,12, 4) . "-" . substr($hBadgeUUID,16, 4) . "-" . substr($hBadgeUUID,20,12);
			$sBadgeUUID = strtolower($sBadgeUUID);
			$aBadges[$sBadgeUUID] = true;
		}

		$sHTMLReturn = $sHTMLReturn . "TN-Grid Badges<BR><BR>";

		// Make sure we have badges to show
//		if (count($aBadges) == 0) {
//			$sHTMLReturn = $sHTMLReturn . "No badges to show.";
//			return $sHTMLReturn;		
//			exit();
//		}
		
		// ===== Badges - "Credits Granted" =====
		$sHTMLReturn = $sHTMLReturn . "<table class=\"badges\" width=100% borderstyle=3 text-align=center>";
		$sHTMLReturn = $sHTMLReturn . "<tr class=\"badges\"><th class=\"badges\" colspan=\"10\">Badges by Credit</th></tr>";
		$sHTMLReturn = $sHTMLReturn . "<tr class=\"badges\">";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">50K<BR>(Bronze)</td><td class=\"badges\">100K<BR>(Silver)</td><td class=\"badges\">500K<BR>(Gold)</td>";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">1M<BR>(Amethyst)</td><td class=\"badges\">2M<BR>(Ruby)</td><td class=\"badges\">5M<BR>(Turquoise)</td>";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">10M<BR>(Jade)</td><td class=\"badges\">20M<BR>(Sapphire)</td>";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">50M<BR>(Emerald)</td><td class=\"badges\">100M<BR>(Diamond)</td>";
		$sHTMLReturn = $sHTMLReturn . "</tr>";

		$sHTMLReturn = $sHTMLReturn . "<tr class=\"badges\">";
		if ($aBadges["222659fd-6cee-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/222659fd-6cee-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["22265a34-6cee-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/22265a34-6cee-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["22265a54-6cee-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/22265a54-6cee-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["22265a70-6cee-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/22265a70-6cee-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["22265a8d-6cee-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/22265a8d-6cee-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["22265aa9-6cee-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/22265aa9-6cee-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["22265ac3-6cee-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/22265ac3-6cee-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["22265ae0-6cee-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/22265ae0-6cee-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["22265afb-6cee-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/22265afb-6cee-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["6f4f579f-6cb4-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/6f4f579f-6cb4-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		$sHTMLReturn = $sHTMLReturn . "</tr>";

		$sHTMLReturn = $sHTMLReturn . "</table>";
		$sHTMLReturn = $sHTMLReturn . "</table><BR><BR>";

		// ===== Badges - "Credits Granted" =====
		$sHTMLReturn = $sHTMLReturn . "<table class=\"badges\" width=100% borderstyle=3 text-align=center>";
		$sHTMLReturn = $sHTMLReturn . "<tr class=\"badges\"><th class=\"badges\" colspan=\"3\">Top \"Recent Average Credit\" Badges</th></tr>";
		$sHTMLReturn = $sHTMLReturn . "<tr class=\"badges\">";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">25%</td><td class=\"badges\">10%</td><td class=\"badges\">1%</td>";
		$sHTMLReturn = $sHTMLReturn . "</tr>";

		$sHTMLReturn = $sHTMLReturn . "<tr class=\"badges\">";
		if ($aBadges["6f4f57bb-6cb4-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/6f4f57bb-6cb4-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["6f4f57d7-6cb4-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/6f4f57d7-6cb4-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["6f4f57f3-6cb4-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/6f4f57f3-6cb4-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		$sHTMLReturn = $sHTMLReturn . "</tr>";

		$sHTMLReturn = $sHTMLReturn . "</table>";
		
		// return HTML string
		return $sHTMLReturn;
	}
?>