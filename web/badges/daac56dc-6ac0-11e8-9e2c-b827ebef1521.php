<?php

	// NFS@Home
	
	function GetBadges() {
		$sProjectID = "daac56dc-6ac0-11e8-9e2c-b827ebef1521";  // Assigned project UUID (don't change this)
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
//						} elseif (preg_match('/<create_time>(.*)<\/create_time>/',$line,$tc) > 0) {
//							$iCreateTime=$tc[1];
						}
					}
//					$fp = FALSE;
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
		// NFS Badge ID --- Badge UUID
		$aBadgesIDs[8] = "87bdf172-6c50-11e8-9e2c-b827ebef1521";	// 10K (Bronze)
		$aBadgesIDs[9] = "87bdf1c8-6c50-11e8-9e2c-b827ebef1521";	// 100K (Silver)
		$aBadgesIDs[10] = "87bdf1a9-6c50-11e8-9e2c-b827ebef1521";	// 500K (Gold)
		$aBadgesIDs[11] = "87bdf1e3-6c50-11e8-9e2c-b827ebef1521";	// 1M (Amethyst)
		$aBadgesIDs[12] = "87bdf200-6c50-11e8-9e2c-b827ebef1521";	// 5M (Turquoise)
		$aBadgesIDs[13] = "87bdf21d-6c50-11e8-9e2c-b827ebef1521";	// 10M (Sapphire)
		$aBadgesIDs[14] = "87bdf238-6c50-11e8-9e2c-b827ebef1521";	// 50M (Ruby) (unconfirmed)
		$aBadgesIDs[15] = "87bdf254-6c50-11e8-9e2c-b827ebef1521";	// 100M (Emerald)(unconfirmed)
		$aBadgesIDs[16] = "87bdf26f-6c50-11e8-9e2c-b827ebef1521";	// 500M (Diamond)(unconfirmed)

		// ===== Badges earned by credits for 14e application =====
		$aBadgesIDs[17] = "90246efc-6c50-11e8-9e2c-b827ebef1521";	// 10K (Bronze)
		$aBadgesIDs[18] = "90246f2d-6c50-11e8-9e2c-b827ebef1521";	// 100K (Silver)(unconfirmed)
		$aBadgesIDs[19] = "90246f4b-6c50-11e8-9e2c-b827ebef1521";	// 500K (Gold)(unconfirmed)
		$aBadgesIDs[20] = "90246f67-6c50-11e8-9e2c-b827ebef1521";	// 1M (Amethyst)(unconfirmed)
		$aBadgesIDs[21] = "90246f84-6c50-11e8-9e2c-b827ebef1521";	// 5M (Turquoise)(unconfirmed)
		$aBadgesIDs[22] = "90246fa0-6c50-11e8-9e2c-b827ebef1521";	// 10M (Sapphire) (unconfirmed)
		$aBadgesIDs[23] = "90246fbb-6c50-11e8-9e2c-b827ebef1521";	// 50M (Ruby) (unconfirmed)
		$aBadgesIDs[24] = "90246fda-6c50-11e8-9e2c-b827ebef1521";	// 100M (Emerald)(unconfirmed)
		$aBadgesIDs[25] = "90246ff6-6c50-11e8-9e2c-b827ebef1521";	// 500M (Diamond)(unconfirmed)

		// ===== Badges earned by credits for 15e application =====
		$aBadgesIDs[26] = "94f086e8-6c50-11e8-9e2c-b827ebef1521";	// 10K (Bronze)
		$aBadgesIDs[27] = "94f0871d-6c50-11e8-9e2c-b827ebef1521";	// 100K (Silver)
		$aBadgesIDs[28] = "94f0873b-6c50-11e8-9e2c-b827ebef1521";	// 500K (Gold) (unconfirmed)
		$aBadgesIDs[29] = "94f08756-6c50-11e8-9e2c-b827ebef1521";	// 1M (Amethyst) (unconfirmed)
		$aBadgesIDs[30] = "94f08772-6c50-11e8-9e2c-b827ebef1521";	// 5M (Turquoise) (unconfirmed)
		$aBadgesIDs[31] = "94f0878d-6c50-11e8-9e2c-b827ebef1521";	// 10M (Sapphire) (unconfirmed)
		$aBadgesIDs[32] = "94f087a9-6c50-11e8-9e2c-b827ebef1521";	// 50M (Ruby) (unconfirmed)
		$aBadgesIDs[33] = "94f087c6-6c50-11e8-9e2c-b827ebef1521";	// 100M (Emerald)(unconfirmed)
		$aBadgesIDs[34] = "94f087e1-6c50-11e8-9e2c-b827ebef1521";	// 500M (Diamond)(unconfirmed)

		// ===== Badges earned by credits for 16e application =====
		$aBadgesIDs[35] = "99a57084-6c50-11e8-9e2c-b827ebef1521";	// 10K (Bronze)
		$aBadgesIDs[36] = "99a570b8-6c50-11e8-9e2c-b827ebef1521";	// 100K (Silver)
		$aBadgesIDs[37] = "99a570d6-6c50-11e8-9e2c-b827ebef1521";	// 500K (Gold)
		$aBadgesIDs[38] = "99a570f2-6c50-11e8-9e2c-b827ebef1521";	// 1M (Amethyst)
		$aBadgesIDs[39] = "99a5710e-6c50-11e8-9e2c-b827ebef1521";	// 5M (Turquoise) (unconfirmed)
		$aBadgesIDs[40] = "99a5712a-6c50-11e8-9e2c-b827ebef1521";	// 10M (Sapphire)
		$aBadgesIDs[41] = "99a57145-6c50-11e8-9e2c-b827ebef1521";	// 50M (Ruby) (unconfirmed)
		$aBadgesIDs[42] = "99a57163-6c50-11e8-9e2c-b827ebef1521";	// 100M (Emerald)(unconfirmed)
		$aBadgesIDs[43] = "99a5717f-6c50-11e8-9e2c-b827ebef1521";	// 500M (Diamond)(unconfirmed)

		// ===== Badges earned by recent average credit for top % =====
		// TODO figure out how to support these (permanent or not?)
		$aBadgesIDs[1] = "6f4f572d-6cb4-11e8-9e2c-b827ebef1521";	// Top 1% in average credit (Gold)
		$aBadgesIDs[2] = "6f4f5764-6cb4-11e8-9e2c-b827ebef1521";	// Top 5% in average credit (Silver)
		$aBadgesIDs[3] = "6f4f5784-6cb4-11e8-9e2c-b827ebef1521";	// Top 25% in average credit (Bronze)

		
		foreach ($aBadgeID as $i => $b) {
			$sQuery = "INSERT INTO badges (badge_uuid, project_uuid, awarded) ";
			$sQuery = $sQuery . "VALUES (unhex(replace('" . $aBadgesIDs[$i] . "','-','')), unhex(replace('" . $sProjectID . "','-','')), true) ";
			$sQuery = $sQuery . "ON DUPLICATE KEY UPDATE awarded=true;";
			mysqli_query($db_conn,$sQuery);
		}

		// Clean up time

		$sQuery = "INSERT INTO project_data (badge_lastupdate, uuid) ";
		$sQuery = $sQuery . "VALUES (" . $iCurrentTime . ", unhex(replace('" . $sProjectID . "','-',''))) ";
		$sQuery = $sQuery . "ON DUPLICATE KEY UPDATE badge_lastupdate=" . $iCurrentTime . ";";
		mysqli_query($db_conn,$sQuery);

		return true;
	}

	function ShowEarnedBadgesHTML() {
		// Figure out the badges earned so far and return a HTML formatted string to display in a web browser.
		// TODO language (EN / DE / ??) specific ?
		$sProjectID = "daac56dc-6ac0-11e8-9e2c-b827ebef1521";  // Assigned project UUID (don't change this)
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

		$sHTMLReturn = $sHTMLReturn . "NFS@Home Badges<BR><BR>";

		// Make sure we have badges to show
//		if (count($aBadges) == 0) {
//			$sHTMLReturn = $sHTMLReturn . "No badges to show.";
//			return $sHTMLReturn;		
//			exit();
//		}
		
		// ===== Badges - "Credits Granted" =====
		$sHTMLReturn = $sHTMLReturn . "<table class=\"badges\" width=100% borderstyle=3 text-align=center>";
		$sHTMLReturn = $sHTMLReturn . "<tr class=\"badges\"><th class=\"badges\" colspan=\"21\">Badges by Credit</th></tr>";
		$sHTMLReturn = $sHTMLReturn . "<tr class=\"badges\">";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">Application</td>";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">10K<BR>(Bronze)</td><td class=\"badges\">100K<BR>(Silver)</td><td class=\"badges\">500K<BR>(Gold)</td>";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">1M<BR>(Amethyst)</td><td class=\"badges\">5M<BR>(Turquoise)</td>";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">10M<BR>(Sapphire)</td><td class=\"badges\">50M<BR>(Ruby)</td>";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">100M<BR>(Emerald)</td><td class=\"badges\">500M<BR>(Diamond)</td>";
		$sHTMLReturn = $sHTMLReturn . "</tr>";

		$sHTMLReturn = $sHTMLReturn . "<tr class=\"badges\">";
		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">14e (app)</td>";
		if ($aBadges["90246efc-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/90246efc-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["90246f2d-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/90246f2d-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["90246f4b-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/90246f4b-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["90246f67-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/90246f67-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["90246f84-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/90246f84-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["90246fa0-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/90246fa0-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["90246fbb-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/90246fbb-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["90246fda-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/90246fda-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["90246ff6-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/90246ff6-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		$sHTMLReturn = $sHTMLReturn . "</tr>";

		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">15e (app)</td>";
		if ($aBadges["94f086e8-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/94f086e8-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["94f0871d-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/94f0871d-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["94f0873b-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/94f0873b-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["94f08756-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/94f08756-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["94f08772-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/94f08772-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["94f0878d-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/94f0878d-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["94f087a9-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/94f087a9-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["94f087c6-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/94f087c6-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["94f087e1-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/94f087e1-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		$sHTMLReturn = $sHTMLReturn . "</tr>";

		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">16e (app)</td>";
		if ($aBadges["99a57084-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/99a57084-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["99a570b8-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/99a570b8-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["99a570d6-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/99a570d6-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["99a570f2-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/99a570f2-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["99a5710e-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/99a5710e-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["99a5712a-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/99a5712a-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["99a57145-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/99a57145-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["99a57163-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/99a57163-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["99a5717f-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/99a5717f-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		$sHTMLReturn = $sHTMLReturn . "</tr>";

		$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\">Credits (Total)</td>";
		if ($aBadges["87bdf172-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/87bdf172-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["87bdf1c8-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/87bdf1c8-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["87bdf1a9-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/87bdf1a9-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["87bdf1e3-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/87bdf1e3-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["87bdf200-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/87bdf200-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["87bdf21d-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/87bdf21d-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["87bdf238-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/87bdf238-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["87bdf254-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/87bdf254-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		if ($aBadges["87bdf26f-6c50-11e8-9e2c-b827ebef1521"]) {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"><img src=\"/badges/images/87bdf26f-6c50-11e8-9e2c-b827ebef1521.png\"></td>";
		} else {
			$sHTMLReturn = $sHTMLReturn . "<td class=\"badges\"></td>";
		}
		$sHTMLReturn = $sHTMLReturn . "</tr>";

		$sHTMLReturn = $sHTMLReturn . "</table>";
		
		// return HTML string
		return $sHTMLReturn;
	}
?>