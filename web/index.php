<?php
	date_default_timezone_set('UTC');
	include "./settings/settings.php";

	//Variablen initialisieren
	$sum1h_total = 0;
	$sum2h_total = 0;
	$sum6h_total = 0;
	$sum12h_total = 0;
	$sum_today_total = 0;
	$sum_yesterday_total = 0;
	$pie_other_retired = 0;
	$pie_other = 0;
	$pie_html = "";

	############################################################
	# Beginn fuer Datenzusammenstellung User
	$query_getUserData = mysqli_query($db_conn, "SELECT * from boinc_user");  //alle Userdaten einlesen
	if ( !$query_getUserData ) { 	
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	} elseif  ( mysqli_num_rows($query_getUserData) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Die Tabelle boinc_user enthält keine Daten.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	while ($row = mysqli_fetch_assoc($query_getUserData)) {
		$boinc_username = $row["boinc_name"];
		$boinc_wcgname = $row["wcg_name"];
		$boinc_teamname = $row["team_name"];
		$cpid = $row["cpid"];
		$datum_start = $row["lastupdate_start"];
		$datum = $row["lastupdate"];
	}
	
	$lastupdate_start = date("d.m.Y H:i:s", $datum_start);
	$lastupdate = date("H:i:s", $datum);
	# Ende Datenzusammenstellung User
	############################################################
	
	# Berechnung der Zeitabstaende fuer Anzeige der letzten 48 Stunden bzw. letzte 30 Tage bei Stunden- bzw. Tages-Output
	$timestamp_hour = date("Y-m-d H:i:s", mktime(date("H"), 0, 0, date("m"), date("d") - 2, date("Y")));  //letzte 48 Stunden bei Stunden-Output
	$timestamp_day = date("Y-m-d H:i:s", mktime(date("H"), 0, 0, date("m"), date("d") - 31, date("Y")));  // letzte 31 Tage bei Tages-Output
	
	# Berechnung der aktuellen Gesamt-Credits bei allen Projekten des Users
	$query_getTotalCredits = mysqli_query($db_conn, "SELECT SUM(total_credits) AS sum_total from boinc_grundwerte");
	if ( !$query_getTotalCredits ) { 	
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	} elseif  ( mysqli_num_rows($query_getTotalCredits) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Die Tabelle boinc_grundwerte enthält keine Daten.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	$row2 = mysqli_fetch_assoc($query_getTotalCredits);
	$sum_total = $row2["sum_total"];
	
	# Berechnung der aktuellen Gesamt-Pendings-Credits bei allen Projekten des Users
	$query_getTotalPendingCredits = mysqli_query($db_conn, "SELECT SUM(pending_credits) AS sum_total from boinc_grundwerte");
	if ( !$query_getTotalPendingCredits ) { 	
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	} elseif  ( mysqli_num_rows($query_getTotalPendingCredits) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Die Tabelle boinc_grundwerte enthält keine Daten.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	$row2 = mysqli_fetch_assoc($query_getTotalPendingCredits);
	$sum_pendings = $row2["sum_total"];
	
	##########################################################################
	# Erhebung der Projekt-Daten
	##########################################################################
	
	$einsh = mktime(date("H"), 0, 0, date("m"), date("d"), date("Y"));
	$zweih = mktime(date("H") - 1, 0, 0, date("m"), date("d"), date("Y"));
	$sechsh = mktime(date("H") - 5, 0, 0, date("m"), date("d"), date("Y"));
	$zwoelfh = mktime(date("H") - 11, 0, 0, date("m"), date("d"), date("Y"));
	
	$query_getAllProjects = mysqli_query($db_conn, "SELECT * FROM boinc_grundwerte ORDER BY project ASC");  //alle Projektgrunddaten einlesen
	if ( !$query_getAllProjects ) { 	
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	} elseif  ( mysqli_num_rows($query_getAllProjects) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Die Tabelle boinc_grundwerte enthält keine Daten.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	while ($row = mysqli_fetch_assoc($query_getAllProjects)) {
		
		if ($row["project_status"] <= 1) {
			
			############################################################
			# Daten fuer Tabelle zuammenstellen
			$shortname = $row["project_shortname"];
			$table_row["project_name"] = $row["project"];
			$table_row["total_credits"] = $row["total_credits"];
			$table_row["pending_credits"] = $row["pending_credits"];
			$table_row["project_home_link"] = $row["project_homepage_url"];
			$table_row["user_stats_vorhanden"] = $row["project_status"];
			
			#Daten fuer letzte Stunde holen
			$query_getOutput1h = mysqli_query($db_conn,"SELECT sum(credits) AS sum1h FROM boinc_werte WHERE project_shortname='" . $shortname . "' AND time_stamp>'" . $einsh . "'");
			if ( !$query_getOutput1h || mysqli_num_rows($query_getOutput1h) === 0 ) { 	
				$connErrorTitle = "Datenbankfehler";
				$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
										Es bestehen wohl Probleme mit der Datenbankanbindung.";
				include "./errordocs/db_initial_err.php";
				exit();
			}
			$row2 = mysqli_fetch_assoc($query_getOutput1h);
			$table_row["sum1h"] = $row2["sum1h"];
			$sum1h_total += $table_row["sum1h"];
			
			#Daten der letzten 2 Stunden holen
			$query_getOutput2h = mysqli_query($db_conn,"SELECT sum(credits) AS sum2h FROM boinc_werte WHERE project_shortname='" . $shortname . "' AND time_stamp>'" . $zweih . "'");
			if ( !$query_getOutput2h || mysqli_num_rows($query_getOutput2h) === 0 ) { 	
				$connErrorTitle = "Datenbankfehler";
				$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
										Es bestehen wohl Probleme mit der Datenbankanbindung.";
				include "./errordocs/db_initial_err.php";
				exit();
			}
			$row2 = mysqli_fetch_assoc($query_getOutput2h);
			$table_row["sum2h"] = $row2["sum2h"];
			$sum2h_total += $table_row["sum2h"];
			
			#Daten der letzten 6 Stunden holen
			$query_getOutput6h = mysqli_query($db_conn,"SELECT sum(credits) AS sum6h FROM boinc_werte WHERE project_shortname='" . $shortname . "' AND time_stamp>'" . $sechsh . "'");
			if ( !$query_getOutput6h || mysqli_num_rows($query_getOutput6h) === 0 ) { 	
				$connErrorTitle = "Datenbankfehler";
				$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
										Es bestehen wohl Probleme mit der Datenbankanbindung.";
				include "./errordocs/db_initial_err.php";
				exit();
			}
			$row2 = mysqli_fetch_assoc($query_getOutput6h);
			$table_row["sum6h"] = $row2["sum6h"];
			$sum6h_total += $table_row["sum6h"];
			
			#Daten der letzten 12 Stunden holen
			$query_getOutput12h = mysqli_query($db_conn,"SELECT sum(credits) AS sum12h FROM boinc_werte WHERE project_shortname='" . $shortname . "' AND time_stamp>'" . $zwoelfh . "'");
			if ( !$query_getOutput12h || mysqli_num_rows($query_getOutput12h) === 0 ) { 	
				$connErrorTitle = "Datenbankfehler";
				$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
										Es bestehen wohl Probleme mit der Datenbankanbindung.";
				include "./errordocs/db_initial_err.php";
				exit();
			}
			$row2 = mysqli_fetch_assoc($query_getOutput12h);
			$table_row["sum12h"] = $row2["sum12h"];
			$sum12h_total += $table_row["sum12h"];
			
			#Aktueller Tagesoutput
			$tagesanfang = mktime(0, 0, 1, date("m"), date("d"), date("Y"));
			$query_getOutputToday = mysqli_query($db_conn,"SELECT sum(credits) AS sum_today FROM boinc_werte WHERE project_shortname='" . $shortname . "' AND time_stamp>'" . $tagesanfang . "'");
			if ( !$query_getOutputToday || mysqli_num_rows($query_getOutputToday) === 0 ) { 	
				$connErrorTitle = "Datenbankfehler";
				$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
										Es bestehen wohl Probleme mit der Datenbankanbindung.";
				include "./errordocs/db_initial_err.php";
				exit();
			}
			$row2 = mysqli_fetch_assoc($query_getOutputToday);
			$table_row["sum_today"] = $row2["sum_today"];
			$sum_today_total += $table_row["sum_today"];
			
			#Tagesoutput gestern
			$gestern_anfang = mktime(0, 0, 1, date("m"), date("d") - 1, date("Y"));
			$gestern_ende = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
			
			$query_getOutputYesterday = mysqli_query($db_conn,"SELECT sum(credits) AS sum_yesterday FROM boinc_werte WHERE project_shortname='" . $shortname . "' AND time_stamp BETWEEN '" . $gestern_anfang . "' AND '" . $gestern_ende . "'");
			if ( !$query_getOutputYesterday || mysqli_num_rows($query_getOutputYesterday) === 0 ) { 	
				$connErrorTitle = "Datenbankfehler";
				$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
										Es bestehen wohl Probleme mit der Datenbankanbindung.";
				include "./errordocs/db_initial_err.php";
				exit();
			}
			$row2 = mysqli_fetch_assoc($query_getOutputYesterday);
			$table_row["sum_yesterday"] = $row2["sum_yesterday"];
			$sum_yesterday_total += $table_row["sum_yesterday"];
			
			$table_row["proz_anteil"] = sprintf("%01.2f", $row["total_credits"] * 100 / $sum_total);
			$table_row["project_link"] = "project.php?projectid=" . $shortname . "";
			$table_row["retired"] = false;
			
			$table[] = $table_row;
			$pie_array = $table_row;
			# Ende Datenzusammenstellung fuer Tabelle
			############################################################
			
			} else {
			
			############################################################
			# Daten fuer Tabelle beendete Projekte zuammenstellen
			$shortname = $row["project_shortname"];
			$table_row["project_name"] = $row["project"];
			$table_row["total_credits"] = $row["total_credits"];
			$table_row["pending_credits"] = $row["pending_credits"];
			$table_row["project_home_link"] = $row["project_homepage_url"];
			$table_row["user_stats_vorhanden"] = $row["project_status"];
			$table_row["proz_anteil"] = sprintf("%01.2f", $row["total_credits"] * 100 / $sum_total);
			$table_row["project_link"] = "project.php?projectid=" . $shortname . "";
			$table_row["retired"] = true;
			$table_retired[] = $table_row;
			$pie_array = $table_row;
		}
		
		############################################################
		# Beginn fuer Datenzusammenstellung Tortendiagramm
		if ($table_row["proz_anteil"] >= $separat && !$table_row["retired"]) {
			$pie_html .= "	['" . $pie_array["project_name"] . "',	 " . round($pie_array["total_credits"] * 100 / $sum_total, 2) . "],\n";
			} else {
			if (!$table_row["retired"]) $pie_other += ($pie_array["total_credits"] * 100 / $sum_total);
			else $pie_other_retired += ($pie_array["total_credits"] * 100 / $sum_total);
		}
		# Ende Datenzusammenstellung Tortendiagramm
		############################################################
		
	}
	
	############################################################
	# Zusammenfassung weiterer Projekte nur anzeigen, wenn vorhanden
	if ($pie_other > 0) {
		$pie_html .= "	['" . $tr_ch_pie_zwp . "',	 " . round($pie_other, 2) . "],\n";
	}
	if ($pie_other_retired > 0) {
		$pie_html .= "	['" . $tr_ch_pie_ret . "',	 " . round($pie_other_retired, 2) . "]\n";
	}
	
	############################################################
	# Beginn Datenzusammenstellung Stunden-Gesamt-Output
	$query_getTotalOutputPerHour = mysqli_query($db_conn,"SELECT time_stamp, credits FROM boinc_werte WHERE project_shortname='gesamt'");
	if ( !$query_getTotalOutputPerHour ) { 	
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	} elseif  ( mysqli_num_rows($query_getTotalOutputPerHour) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es noch keine Daten für eine Gesamtberechnung erstellt.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	$output_html = "";
	while ($row = mysqli_fetch_assoc($query_getTotalOutputPerHour)) {
		$timestamp = ($row["time_stamp"]) * 1000;
		$output_html .= "[" . $timestamp . ", " . $row["credits"] . "], ";
	}
	$output_html = substr($output_html, 0, -2);
	# Ende Datenzusammenstellung
	############################################################
	
	############################################################
	# Beginn Datenzusammenstellung Gesamt-Credits
	$query_getTotalOutputPerDay = mysqli_query($db_conn,"SELECT time_stamp, total_credits, pending_credits FROM boinc_werte_day WHERE project_shortname='gesamt'");
	if ( !$query_getTotalOutputPerDay ) { 	
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	} elseif  ( mysqli_num_rows($query_getTotalOutputPerDay) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es noch keine Daten für eine Gesamtberechnung erstellt.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	$output_gesamt_html = "";
	$output_gesamt_pendings_html = "";
	while ($row2 = mysqli_fetch_assoc($query_getTotalOutputPerDay)) {
		$timestamp2 = ($row2["time_stamp"]) * 1000;
		$output_gesamt_html .= "[" . $timestamp2 . ", " . $row2["total_credits"] . "], ";
		$output_gesamt_pendings_html .= "[" . $timestamp2 . ", " . $row2["pending_credits"] . "], ";
	}
	$output_gesamt_html = substr($output_gesamt_html, 0, -2);
	$output_gesamt_pendings_html = substr($output_gesamt_pendings_html, 0, -2);
	# Ende Datenzusammenstellung Gesamt
	############################################################
	
	##########################################################################
	# Ende Erhebung der Projekt-Daten
	##########################################################################
?>

<?php
	//Sprache feststellen
	if (isset($_GET["lang"])) $lang = $_GET["lang"];
	else $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	
	//Sprachpaket HP einlesen
	if (file_exists("./lang/" . $lang . ".txt.php")) include "./lang/" . $lang . ".txt.php";
	else include "./lang/en.txt.php";

	//Sprachpaket Highcharts einlesen
	if (file_exists("./lang/highstock_" . $lang . ".js")) include "./lang/highstock_" . $lang . ".js";
	else include "./lang/highstock_en.js";
?>

	<?php include("./header.php"); ?>

	<!-- Highcharts definieren  -->
	<?php include("./modules/highcharts/pie.js"); ?>
	<?php include("./modules/highcharts/output_gesamt.js"); ?>
	<?php include("./modules/highcharts/output_gesamt_hour.js"); ?>
	<?php include("./modules/highcharts/output_gesamt_day.js"); ?>
	<?php include("./modules/highcharts/output_gesamt_week.js"); ?>
	<?php include("./modules/highcharts/output_gesamt_month.js"); ?>
	<?php include("./modules/highcharts/output_gesamt_year.js"); ?>

	<div class="alert info-lastupdate" role="alert">
		<div class="container">
			<b><?php echo $text_header_lu ?>:</b> <?php echo $lastupdate_start ?> - <?php echo $lastupdate ?> (UTC)
		</div>
	</div>

	<div class = "container-fluid">
		<ul class="nav nav-tabs nav-space justify-content-center nav-tabs-userstats" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="projekte-tab" data-toggle="tab" href="#projekte" role="tab" aria-controls="projekte" aria-selected="true"><i class="fa fa-table"></i> <?php echo "$tabs_projects" ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="pie-tab" data-toggle="tab" href="#pie" role="tab" aria-controls="pie" aria-selected="false"><i class="fa fa-pie-chart"></i> <?php echo "$tabs_pie" ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="gesamt-tab" data-toggle="tab" href="#gesamt" role="tab" aria-controls="gesamt" aria-selected="false"><i class="fa fa-area-chart"></i> <?php echo "$tabs_total" ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="stunde-tab" data-toggle="tab" href="#stunde" role="tab" aria-controls="stunde" aria-selected="false"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_hour" ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tag-tab" data-toggle="tab" href="#tag" role="tab" aria-controls="tag" aria-selected="false"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_day" ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="woche-tab" data-toggle="tab" href="#woche" role="tab" aria-controls="woche" aria-selected="false"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_week" ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="monat-tab" data-toggle="tab" href="#monat" role="tab" aria-controls="monat" aria-selected="false"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_month" ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="jahr-tab" data-toggle="tab" href="#jahr" role="tab" aria-controls="jahr" aria-selected="false"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_year" ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="badges-tab" data-toggle="tab" href="#badges" role="tab" aria-controls="badges" aria-selected="false"><i class="fa fa-certificate"></i> <?php echo "$tabs_badge" ?></a>
			</li>
		</ul>
	</div>

	<div class="tab-content flex1" id="myTabContent">

		<div id="projekte" class="tab-pane fade show active" role="tabpanel" aria-labelledby="projekte-tab">
			<table id="table_projects" class="table table-sm table-striped table-hover table-responsive-sm table-ellipsis" width="100%">					
				<thead>
					<tr>
						<td class="dunkelblau textblau"><b><?php echo $text_boinc_total ?></b></td>
						<td class="dunkelblau textblau align-middle text-center"><b><?php #echo $tr_th_detail ?></b></td>
						<td class="dunkelblau textblau"><b><?php echo number_format($sum_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="dunkelblau textblau d-none d-sm-table-cell"><b>100%</b></td>
						<td class="dunkelblau textblau d-none d-sm-table-cell">
						<b><?php echo number_format($sum1h_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="dunkelblau textblau d-none d-lg-table-cell">
						<b><?php echo number_format($sum2h_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="dunkelblau textblau d-none d-lg-table-cell">
						<b><?php echo number_format($sum6h_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="dunkelblau textblau d-none d-md-table-cell">
						<b><?php echo number_format($sum12h_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class = "dunkelgruen textgruen">
						<b><?php echo number_format($sum_today_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class = "dunkelblau text-blau d-none d-sm-table-cell">
						<b><?php echo number_format($sum_yesterday_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class = "dunkelrot textrot d-none d-md-table-cell">
						<b><?php echo number_format($sum_pendings, 0, $dec_point, $thousands_sep) ?></b></td>
					</tr>
					<tr>
						<th class = "dunkelgrau textgrau"><?php echo $tr_tb_pr; ?></th>
						<th class = "dunkelgrau textgrau no-sort align-middle text-center"> </th>
						<th class = "dunkelgrau textgrau"><?php echo $tr_tb_cr; ?></th>
						<th class = "dunkelgrau textgrau d-none d-sm-table-cell">%</th>
						<th class = "dunkelgrau textgrau d-none d-sm-table-cell"><?php echo $tr_tb_01; ?></th>
						<th class = "dunkelgrau textgrau d-none d-lg-table-cell"><?php echo $tr_tb_02; ?></th>
						<th class = "dunkelgrau textgrau d-none d-lg-table-cell"><?php echo $tr_tb_06; ?></th>
						<th class = "dunkelgrau textgrau d-none d-md-table-cell"><?php echo $tr_tb_12; ?></th>
						<th class = "dunkelgruen textgruen"><?php echo $tr_tb_to; ?></th>
						<th class = "dunkelblau textblau d-none d-sm-table-cell"><?php echo $tr_tb_ye; ?></th>
						<th class = "dunkelrot textrot d-none d-md-table-cell"><?php echo $tr_tb_pe; ?></th>
					</tr>
				</thead>
				<tbody>
					<!-- Fuer jedes Projekt eine Zeile in die Tabelle hinzufuegen -->						
					<?php
						foreach ($table as $table_row) {
							echo "<tr>
								<td><a href='" . $table_row["project_home_link"] . "'>" . $table_row["project_name"] ."</a></td>
								<td class='align-middle text-center'><a href='" . $table_row["project_link"] . "'><i class='fa fa-bar-chart'></i></a></td>
								<td><b>" . number_format($table_row["total_credits"], 0, $dec_point, $thousands_sep) . "</b></td>
								<td class='d-none d-sm-table-cell'>" . number_format($table_row["proz_anteil"], 2, $dec_point, $thousands_sep) . "</td>";
								if ($table_row["sum1h"] != "") {
									echo "<td class='d-none d-sm-table-cell'>" . number_format($table_row['sum1h'], 0, $dec_point, $thousands_sep) . "</td>";
								} else
									echo "<td class='d-none d-sm-table-cell'>-</td>";
								if ($table_row["sum2h"] != "") {
									echo "<td class='d-none d-lg-table-cell'>" . number_format($table_row["sum2h"], 0, $dec_point, $thousands_sep) . "</td>";
								} else
									echo "<td class='d-none d-lg-table-cell'>-</td>";
								if ($table_row["sum6h"] != "") {
									echo "<td class='d-none d-lg-table-cell'>" . number_format($table_row["sum6h"], 0, $dec_point, $thousands_sep) . "</td>";
								} else
									echo "  <td class='d-none d-lg-table-cell'>-</td>";
								if ($table_row["sum12h"] != "") {
									echo "  <td class='d-none d-md-table-cell'>" . number_format($table_row["sum12h"], 0, $dec_point, $thousands_sep) . "</td>";
								} else
									echo "  <td class='d-none d-md-table-cell'>-</td>";
								if ($table_row["sum_today"] != "") {
									echo "  <td class = 'gruen textgruen'><b>" . number_format($table_row["sum_today"], 0, $dec_point, $thousands_sep) . "</b></td>";
								} else
									echo "  <td class = 'gruen text gruen'>-</td>";
								if ($table_row["sum_yesterday"] != "") {
									echo "  <td class = 'blau textblau d-none d-sm-table-cell'><b>" . number_format($table_row["sum_yesterday"], 0, $dec_point, $thousands_sep) . "</b></td>";
								} else
									echo "  <td class = 'blau textblau d-none d-sm-table-cell'>-</td>";
								if ($table_row["pending_credits"] >> "0") {
									echo "  <td class = 'rot textrot d-none d-md-table-cell'><b>" . number_format($table_row["pending_credits"], 0, $dec_point, $thousands_sep) . "</b></td>";
								} else
									echo "  <td class = 'rot textrot d-none d-md-table-cell'>-</td>
								</tr>";
						}
					?>
					<thead>
						<tr>
							<td class = "dunkelgrau textgrau"><b><?php echo $tr_th2_rp ?></b></td>
							<td class="dunkelgrau textgrau align-middle text-center"><b><?php #echo $tr_tb_det ?>
								<i class="text-muted fa fa-toggle-on fa-lg" aria-hidden="true"></i></b>
							</td>
							<td class = "dunkelgrau textgrau"><b><?php echo $tr_tb_cr ?></b></td>
							<td class = "dunkelgrau textgrau d-none d-sm-table-cell"></td>
							<td class = "dunkelgrau textgrau d-none d-sm-table-cell"><b><?php echo $tr_tb_01 ?></b></td>
							<td class = "dunkelgrau textgrau d-none d-lg-table-cell"><b><?php echo $tr_tb_02 ?></b></td>
							<td class = "dunkelgrau textgrau d-none d-lg-table-cell"><b><?php echo $tr_tb_06 ?></b></td>
							<td class = "dunkelgrau textgrau d-none d-md-table-cell"><b><?php echo $tr_tb_12 ?></b></td>
							<td class = "dunkelgruen textgruen"><b><?php echo $tr_tb_to; ?></b></td>
							<td class = "dunkelblau textblau d-none d-sm-table-cell"><b><?php echo $tr_tb_ye; ?></b></td>
							<td class = "dunkelrot textrot d-none d-md-table-cell"><b><?php echo $tr_tb_pe; ?></b></td>
						</tr>
					</thead>
					
					<?php
						foreach ($table_retired as $table_row_retired) {
							echo "<tr>
									<td class = 'text-muted text-sm'>" . $table_row_retired["project_name"] ."</td>
									<td class='align-middle text-center text-muted test-sm'><a href='" . $table_row_retired["project_link"] . "'><i class='fa fa-bar-chart'></i></a></td>
									<td class = 'text-muted text-sm'><b>" . number_format($table_row_retired["total_credits"], 0, $dec_point, $thousands_sep) . "</b></td>
									<td class = 'text-muted text-sm d-none d-sm-table-cell'>" . number_format($table_row_retired["proz_anteil"], 2, $dec_point, $thousands_sep) . "</td>
									<td class = 'text-muted text-sm d-none d-sm-table-cell'></td>
									<td class = 'text-muted text-sm d-none d-lg-table-cell'></td>
									<td class = 'text-muted text-sm d-none d-lg-table-cell'></td>
									<td class = 'text-muted text-sm d-none d-md-table-cell'></td>
									<td class = 'text-muted text-sm'></td>
									<td class = 'text-muted text-sm d-none d-sm-table-cell'></td>
									<td class = 'text-muted text-sm d-none d-md-table-cell'></td>
								</tr>";
						}
					?>

								<thead>
									<tr>
										<td class="dunkelblau textblau"><b><?php echo $text_boinc_total ?></b></td>
										<td class="dunkelblau textblau align-middle text-center"><b><?php #echo $tr_th_detail ?></b></td>
										<td class="dunkelblau textblau"><b><?php echo number_format($sum_total, 0, $dec_point, $thousands_sep) ?></b></td>
										<td class="dunkelblau textblau d-none d-sm-table-cell"><b>100%</b></th>
										<td class="dunkelblau textblau d-none d-sm-table-cell">
										<b><?php echo number_format($sum1h_total, 0, $dec_point, $thousands_sep) ?></b></td>
										<td class="dunkelblau textblau d-none d-lg-table-cell">
										<b><?php echo number_format($sum2h_total, 0, $dec_point, $thousands_sep) ?></b></td>
										<td class="dunkelblau textblaud-none d-lg-table-cell">
										<b><?php echo number_format($sum6h_total, 0, $dec_point, $thousands_sep) ?></b></td>
										<td class="dunkelblau textblau d-none d-md-table-cell">
										<b><?php echo number_format($sum12h_total, 0, $dec_point, $thousands_sep) ?></b></td>
										<td class = "dunkelgruen textgruen">
										<b><?php echo number_format($sum_today_total, 0, $dec_point, $thousands_sep) ?></b></td>
										<td class = "dunkelblau textblau d-none d-sm-table-cell">
										<b><?php echo number_format($sum_yesterday_total, 0, $dec_point, $thousands_sep) ?></b></td>
										<td class = "dunkelrot textrot d-none d-md-table-cell">
										<b><?php echo number_format($sum_pendings, 0, $dec_point, $thousands_sep) ?></b></td>
									</tr>
									<tr>
										<th class = "dunkelgrau textgrau"> </th>
										<th class = "dunkelgrau textgrau no-sort align-middle text-center"> </th>
										<th class = "dunkelgrau textgrau"><?php echo $tr_tb_cr; ?></th>
										<th class = "dunkelgrau textgrau d-none d-sm-table-cell">%</th>
										<th class = "dunkelgrau textgrau d-none d-sm-table-cell"><?php echo $tr_tb_01; ?></th>
										<th class = "dunkelgrau textgrau d-none d-lg-table-cell"><?php echo $tr_tb_02; ?></th>
										<th class = "dunkelgrau textgrau d-none d-lg-table-cell"><?php echo $tr_tb_06; ?></th>
										<th class = "dunkelgrau textgrau d-none d-md-table-cell"><?php echo $tr_tb_12; ?></th>
										<th class = "dunkelgruen textgruen"><?php echo $tr_tb_to; ?></th>
										<th class = "dunkelblau textblau d-none d-sm-table-cell"><?php echo $tr_tb_ye; ?></th>
										<th class = "dunkelrot textrot d-none d-md-table-cell"><?php echo $tr_tb_pe; ?></th>
									</tr>
								</thead>
				</tbody>
			</table>
		</div>
	
		<div id="pie" class="tab-pane fade" role="tabpanel" aria-labelledby="pie-tab">
			<div>
				<div id="projektverteilung"></div>
			</div>
		</div>
		
		<div id="gesamt" class="tab-pane fade" role="tabpanel" aria-labelledby="gesamt-tab">
			<div>
				<div id="output"></div>
			</div>
		</div>

		<div id="stunde" class="tab-pane fade" role="tabpanel" aria-labelledby="stunde-tab">
			<div>
				<div id="output_gesamt_hour"></div>
			</div>
		</div>

		<div id="tag" class="tab-pane fade" role="tabpanel" aria-labelledby="tag-tab">
			<div>
				<div id="output_gesamt_day"></div>
			</div>
		</div>

		<div id="woche" class="tab-pane fade" role="tabpanel" aria-labelledby="woche-tab">
			<div>
				<div id="output_gesamt_week"></div>
			</div>
		</div>

		<div id="monat" class="tab-pane fade" role="tabpanel" aria-labelledby="monat-tab">
			<div>
				<div id="output_gesamt_month"></div>
			</div>
		</div>

		<div id="jahr" class="tab-pane fade" role="tabpanel" aria-labelledby="jahr-tab">
			<div>
				<div id="output_gesamt_year"></div>
			</div>
		</div>

		<div id="badges" class="tab-pane fade text-center" role="tabpanel" aria-labelledby="badges-tab">
			<div>
				<br>
				<?php //Userbadge
					if (!$showUserBadges AND !$showWcgLogo AND !$showSgWcgBadges) echo $no_badge ."<br>";
					if ($showUserBadges) {
						echo '<img src="' . $linkUserBadges . '" class="img-fluid center-block"></img><br>';
					};
					if ($showWcgLogo) {
						echo '<img src="' . $linkWcgSig . '" class="img-fluid center-block"></img><br>';
					};
					if ($showSgWcgBadges) {
						echo '<img src="' . $linkSgWcgBadges . '" class="img-fluid center-block"></img><br>';
					};
				?>
				<br>
			</div>
		</div>

	</div> <!--  flex1  -->
	
	<script>
		$(document).ready(function() {
			$('#table_projects').DataTable( {
				"bSortCellsTop": false,
				"language": {
					"decimal": "<?php echo $dec_point; ?>",
					"thousands": "<?php echo $thousands_sep; ?>",
					"search":	"<?php echo $text_search; ?>"
				},
				"columnDefs": [ {
					"targets"  : 'no-sort',
					"orderable": false,
				}],
				"paging": false,
				"info": false
			} );
		} );
	</script>

<?php include("./footer.php"); ?>
