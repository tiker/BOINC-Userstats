<?php
	include "./settings/settings.php";
	date_default_timezone_set('UTC');
	//-----------------------------------------------------------------------------------
	// Ab hier bitte keine Aenderungen vornehmen, wenn man nicht weiß, was man tut!!! :D
	//-----------------------------------------------------------------------------------
	
	// Sprachdefinierung
	if (isset($_GET["lang"])) $lang = $_GET["lang"];
	else $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	
	############################################################
	# Beginn fuer Datenzusammenstellung User
	$result_user = mysqli_query($db_conn, "SELECT * from boinc_user");  //alle Userdaten einlesen
	while ($row = mysqli_fetch_assoc($result_user)) {
		$project_username = $row["boinc_name"];
		$project_wcgname = $row["wcg_name"];
		$project_teamname = $row["team_name"];
		$cpid = $row["cpid"];
		$datum_start = $row["lastupdate_start"];
		$datum = $row["lastupdate"];
	}
	
	$lastupdate_start = date("d.m.Y H:i:s", $datum_start);
	$lastupdate = date("H:i:s", $datum);
	# Ende Datenzusammenstellung User
	############################################################
	
	############################################################
	# Auswahl der Sprache, wenn nicht vorhanden, Nutzung von englischer Sprachdatei
	if (file_exists("./lang/" . $lang . ".txt.php")) include "./lang/" . $lang . ".txt.php";
	else include "./lang/en.txt.php";
	# 
	############################################################
	
	# Berechnung der Zeitabstaende fuer Anzeige der letzten 48 Stunden bzw. letzte 30 Tage bei Stunden- bzw. Tages-Output
	$timestamp_hour = date("Y-m-d H:i:s", mktime(date("H"), 0, 0, date("m"), date("d") - 2, date("Y")));  //letzte 48 Stunden bei Stunden-Output
	$timestamp_day = date("Y-m-d H:i:s", mktime(date("H"), 0, 0, date("m"), date("d") - 31, date("Y")));  // letzte 31 Tage bei Tages-Output
	
	# Berechnung der aktuellen Gesamt-Credits bei allen Projekten des Users
	$query = "SELECT SUM(total_credits) AS sum_total from boinc_grundwerte";
	$result = mysqli_query($db_conn, $query);
	$row2 = mysqli_fetch_assoc($result);
	$sum_total = $row2["sum_total"];
	
	# Berechnung der aktuellen Gesamt-Pendings-Credits bei allen Projekten des Users
	$query = "SELECT SUM(pending_credits) AS sum_total from boinc_grundwerte";
	$result = mysqli_query($db_conn, $query);
	$row2 = mysqli_fetch_assoc($result);
	$sum_pendings = $row2["sum_total"];
	
	##########################################################################
	# Erhebung der Projekt-Daten
	##########################################################################
	
	$einsh = mktime(date("H"), 0, 0, date("m"), date("d"), date("Y"));
	$zweih = mktime(date("H") - 1, 0, 0, date("m"), date("d"), date("Y"));
	$sechsh = mktime(date("H") - 5, 0, 0, date("m"), date("d"), date("Y"));
	$zwoelfh = mktime(date("H") - 11, 0, 0, date("m"), date("d"), date("Y"));
	
	############################################################
	# Gesamtpositionierung erheben
	$result_world_rank = mysqli_query($db_conn, "SELECT rank, rank_team FROM boinc_werte_day WHERE project_shortname='gesamt' ORDER BY time_stamp DESC LIMIT 1");  //alle Userdaten einlesen
	while ($row = mysqli_fetch_assoc($result_world_rank)) {
		$sum_rank_total = $row["rank"];
		$sum_rank_total_avg = $row["rank_team"];
	}
	
	$result_grundwerte = mysqli_query($db_conn, "SELECT * FROM boinc_grundwerte ORDER BY project ASC");  //alle Projektgrunddaten einlesen
	$sum1h_total = 0;
	$sum2h_total = 0;
	$sum6h_total = 0;
	$sum12h_total = 0;
	$sum_today_total = 0;
	$sum_yesterday_total = 0;
	$pie_other_retired = 0;
	$pie_other = 0;
	$pie_html = null;
	while ($row = mysqli_fetch_assoc($result_grundwerte)) {
		
		if ($row["project_status"] <= 1) {
			#warum <=1? sonst überall 1, wann 0?
			
			############################################################
			# Daten fuer Tabelle zuammenstellen
			$shortname = $row["project_shortname"];
			$table_row["project_name"] = $row["project"];
			$table_row["total_credits"] = $row["total_credits"];
			$table_row["pending_credits"] = $row["pending_credits"];
			$table_row["project_home_link"] = $row["project_homepage_url"];
			$table_row["user_stats_vorhanden"] = $row["project_status"];
			
			#Daten fuer letzte Stunde holen
			$query = 'SELECT sum(credits) AS sum1h FROM boinc_werte WHERE project_shortname="' . $shortname . '" AND time_stamp>"' . $einsh . '"';
			$result = mysqli_query($db_conn,$query);
			$row2 = mysqli_fetch_assoc($result);
			$table_row["sum1h"] = $row2["sum1h"];
			$sum1h_total += $table_row["sum1h"];
			
			#Daten der letzten 2 Stunden holen
			$query = 'SELECT sum(credits) AS sum2h FROM boinc_werte WHERE project_shortname="' . $shortname . '" AND time_stamp>"' . $zweih . '"';
			$result = mysqli_query($db_conn,$query);
			$row2 = mysqli_fetch_assoc($result);
			$table_row["sum2h"] = $row2["sum2h"];
			$sum2h_total += $table_row["sum2h"];
			
			#Daten der letzten 6 Stunden holen
			$query = 'SELECT sum(credits) AS sum6h FROM boinc_werte WHERE project_shortname="' . $shortname . '" AND time_stamp>"' . $sechsh . '"';
			$result = mysqli_query($db_conn,$query);
			$row2 = mysqli_fetch_assoc($result);
			$table_row["sum6h"] = $row2["sum6h"];
			$sum6h_total += $table_row["sum6h"];
			
			#Daten der letzten 12 Stunden holen
			$query = 'SELECT sum(credits) AS sum12h FROM boinc_werte WHERE project_shortname="' . $shortname . '" AND time_stamp>"' . $zwoelfh . '"';
			$result = mysqli_query($db_conn,$query);
			$row2 = mysqli_fetch_assoc($result);
			$table_row["sum12h"] = $row2["sum12h"];
			$sum12h_total += $table_row["sum12h"];
			
			#Aktueller Tagesoutput
			$tagesanfang = mktime(0, 0, 1, date("m"), date("d"), date("Y"));
			$query = 'SELECT sum(credits) AS sum_today FROM boinc_werte WHERE project_shortname="' . $shortname . '" AND time_stamp>"' . $tagesanfang . '"';
			$result = mysqli_query($db_conn,$query);
			$row2 = mysqli_fetch_assoc($result);
			$table_row["sum_today"] = $row2["sum_today"];
			$sum_today_total += $table_row["sum_today"];
			
			#Tagesoutput gestern
			$gestern_anfang = mktime(0, 0, 1, date("m"), date("d") - 1, date("Y"));
			$gestern_ende = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
			
			$query = 'SELECT sum(credits) AS sum_yesterday FROM boinc_werte
			WHERE	 project_shortname="' . $shortname . '" AND 
			time_stamp BETWEEN "' . $gestern_anfang . '" AND "' . $gestern_ende . '"';
			$result = mysqli_query($db_conn,$query);
			$row2 = mysqli_fetch_assoc($result);
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
		if ($table_row["proz_anteil"] >= $seperat && !$table_row["retired"]) {
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
	$result_output = mysqli_query($db_conn,"SELECT time_stamp, credits FROM boinc_werte WHERE project_shortname='gesamt'");
	$output_html = null;
	while ($row = mysqli_fetch_assoc($result_output)) {
		$timestamp = ($row["time_stamp"]) * 1000;
		$output_html .= "[" . $timestamp . ", " . $row["credits"] . "], ";
	}
	$output_html = substr($output_html, 0, -2);
	# Ende Datenzusammenstellung
	############################################################
	
	############################################################
	# Beginn Datenzusammenstellung Gesamt-Credits
	$result_output_gesamt = mysqli_query($db_conn,"SELECT time_stamp, total_credits, pending_credits, rank, rank_team FROM boinc_werte_day WHERE project_shortname='gesamt'");
	$output_gesamt_html = null;
	$output_gesamt_pendings_html = null;
	while ($row2 = mysqli_fetch_assoc($result_output_gesamt)) {
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

<?php echo $tr_hp_header; ?>

<!-- Highcharts definieren  -->
<?php include("./charts/pie.js"); ?>
<?php include("./charts/output.js"); ?>
<?php include("./charts/output_gesamt_hour.js"); ?>
<?php include("./charts/output_gesamt_day.js"); ?>
<?php include("./charts/output_gesamt_week.js"); ?>
<?php include("./charts/output_gesamt_month.js"); ?>
<?php include("./charts/output_gesamt_year.js"); ?>

</head>
<body>
	
	<?php if ( $navbar ) echo $tr_hp_nav ?>
	
	<div class="wrapper">
		<!--div class="landing-header"-->
		<div class="header img-reponsive" style="background-image: url('<?php echo $header_backround_url ?>');">
			<div class="container">
				<div class="motto">
					<h1 class="title" style="color: white;"><?php echo "$tr_th_bp" ?></h1>
					<h3>
						<font color="white"><?php echo "$project_username" . " " . $tr_th_ot . " " . $project_teamname ?></font>
					</h3>
					
					<?php //sind laufende WUs im Internet ersichtlich
						if ( $has_boinctasks ) {
							echo '<a href="' . $boinctasks_link . '" class="btn btn-neutral btn-simple"><i class="fa fa-tasks"></i> laufende WUs</a>';
						};
					?>
					
					<?php //Link zu Boinctasks
						if ( $has_boincstats ) {
							echo '<a href="' . $boincstats_link . '" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-bar-chart"></i> BoincStats</a>';
						};
					?>
					<br/>
					<?php //Link zu Team
						if ( $has_team_hp ) {
							echo '<a href="' . $team_hp . '" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-link"></i> SETI.Germany</a>';
						};
					?>
					
					<?php //Link zu WCG
						if ( $has_wcg ) {
							echo '<a href="' . $wcg_link . '" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-globe"></i> World Community Grid</a>';
						};
					?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="alert-info">
		<div class="container">
			<h5><?php echo $tr_th_lu ?>: <?php echo $lastupdate_start ?> - <?php echo $lastupdate ?> (UTC)</h5>
		</div>
	</div>
	
	<div class="nav-tabs-navigation">
		<div class="nav-tabs-wrapper">
			<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
				<li class="active"><a data-toggle="tab" href="#projekte"><i
				class="fa fa-table"></i> <?php echo "$tabs_project" ?></a></li>
				<li><a data-toggle="tab" href="#pie"><i class="fa fa-pie-chart"></i> <?php echo "$tabs_pie" ?></a></li>
				<li><a data-toggle="tab" href="#gesamt"><i class="fa fa-area-chart"></i> <?php echo "$tabs_total" ?></a>
				</li>
				<li><a data-toggle="tab" href="#stunde"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_hour" ?></a></li>
				<li><a data-toggle="tab" href="#tag"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_day" ?></a></li>
				<li><a data-toggle="tab" href="#woche"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_week" ?></a></li>
				<li><a data-toggle="tab" href="#monat"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_month" ?></a></li>
				<li><a data-toggle="tab" href="#jahr"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_year" ?></a></li>
				<li><a data-toggle="tab" href="#badges"><i class="fa fa-certificate"></i> <?php echo "$tabs_badge" ?></a>
				</li>
			</ul>
		</div>
	</div>
	
	<div class="tab-content text-center">
		<div id="projekte" class="tab-pane fade in active">
			<div class="section text-center section-default">
				<div class="container-fluid">
					
					<!--style>@media (max-width: 978px) { .table-condensed td, .table-condensed th { padding: 0 1px !important; } }</style-->
					
					<style>
						@media (max-width: 767px) {
						.table-condensed td,
						.table-condensed th {
						padding: 3px 5px !important;
						}
						
						@media (max-width: 560px) {
						.table-condensed td,
						.table-condensed th {
						padding: 1px 1px !important;
						}
						
						.container-fluid {
						padding-left: 0 !important;
						padding-right: 0 !important;
						}
						}
					</style>
					
					<table class="table table-striped table-hover text-right table-condensed"
					style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
						
						<!-- Fuer jedes Projekt eine Zeile in die Tabelle hinzufuegen -->
						
						<thead class="alert-warning">
							<th class="text-right"><?php echo $tr_tb_pr ?></th>
							<th class="text-right"></th>
							<th class="text-right"><?php echo $tr_tb_cr ?></th>
							<th class="hidden-xs hidden-sm text-right">%</th>
							<th class="hidden-xs text-right"><?php echo $tr_tb_01 ?></th>
							<th class="hidden-xs hidden-sm text-right"><?php echo $tr_tb_02 ?></th>
							<th class="hidden-xs hidden-sm text-right"><?php echo $tr_tb_06 ?></th>
							<th class="hidden-xs text-right"><?php echo $tr_tb_12 ?></th>
							<th class="alert-success text-right"><?php echo $tr_tb_to ?></th>
							<th class="alert-info text-right"><?php echo $tr_tb_ye ?></th>
							<th class="alert-danger hidden-xs text-right"><?php echo $tr_tb_pe ?></th>
						</thead>
						
						
						<!-- Fuer jedes Projekt eine Zeile in die Tabelle hinzufuegen -->
						
						<?php
							foreach ($table as $table_row) {
								echo "<tr class='alert-primary'>";
								echo "  <td>";
								echo "	<a href='" . $table_row["project_home_link"] . "'>" . $table_row["project_name"];
								echo "	</a></td>";
								echo " <td>";
								echo "  <a href='" . $table_row["project_link"] . "'>";
								echo "    <i class='fa fa-bar-chart'></i>";
								echo "  </a>";
								echo "</td>";
								echo "  <td>" . number_format($table_row["total_credits"], 0, $dec_point, $thousands_sep) . "</td>";
								echo "  <td class='hidden-xs hidden-sm'>" . number_format($table_row["proz_anteil"], 2, $dec_point, $thousands_sep) . "</td>";
								if ($table_row["sum1h"] != "") {
									echo "  <td class='hidden-xs'>" . number_format($table_row['sum1h'], 0, $dec_point, $thousands_sep) . "</td>";
								} else
								echo "  <td class='hidden-xs'>-</td>";
								if ($table_row["sum2h"] != "") {
									echo "  <td class='hidden-xs hidden-sm'>" . number_format($table_row["sum2h"], 0, $dec_point, $thousands_sep) . "</td>";
								} else
								echo "  <td class='hidden-xs hidden-sm'>-</td>";
								if ($table_row["sum6h"] != "") {
									echo "  <td class='hidden-xs hidden-sm'>" . number_format($table_row["sum6h"], 0, $dec_point, $thousands_sep) . "</td>";
								} else
								echo "  <td class='hidden-xs hidden-sm'>-</td>";
								if ($table_row["sum12h"] != "") {
									echo "  <td class='hidden-xs'>" . number_format($table_row["sum12h"], 0, $dec_point, $thousands_sep) . "</td>";
								} else
								echo "  <td class='hidden-xs'>-</td>";
								if ($table_row["sum_today"] != "") {
									echo "  <td class='success text-success'><b>" . number_format($table_row["sum_today"], 0, $dec_point, $thousands_sep) . "</b></td>";
								} else
								echo "  <td class='success text-success'>-</td>";
								if ($table_row["sum_yesterday"] != "") {
									echo "  <td class='info text-info'><b>" . number_format($table_row["sum_yesterday"], 0, $dec_point, $thousands_sep) . "</b></td>";
								} else
								echo "  <td class='info text-info'>-</td>";
								if ($table_row["pending_credits"] >> "0") {
									echo "  <td class='danger hidden-xs text-danger'><b>" . number_format($table_row["pending_credits"], 0, $dec_point, $thousands_sep) . "</b></td>";
								} else
								echo "  <td class='danger hidden-xs text-danger'>-</td>";
								echo "</tr>";
							}
						?>
						<tr class="alert-warning">
							<td class="alert-warning"><b><?php echo $tr_th2_rp ?></b></td>
							<td class="alert-warning"><b><?php #echo $tr_tb_det ?></b></td>
							<td class="alert-warning"><b><?php echo $tr_tb_cr ?></b></td>
						<td class="alert-warning hidden-xs hidden-sm"></b></td>
						<td class="alert-warning hidden-xs"><b><?php echo $tr_tb_01 ?></b></td>
						<td class="alert-warning hidden-xs hidden-sm"><b><?php echo $tr_tb_02 ?></b></td>
						<td class="alert-warning hidden-xs hidden-sm"><b><?php echo $tr_tb_06 ?></b></td>
						<td class="alert-warning hidden-xs"><b><?php echo $tr_tb_12 ?></b></td>
						<td class="alert-success"><b><?php echo $tr_tb_to ?></b></td>
						<td class="alert-info"><b><?php echo $tr_tb_ye ?></b></td>
						<td class="alert-danger hidden-xs"><b><?php echo $tr_tb_pe ?></b></td>
					</tr>
					
					<?php
						foreach ($table_retired as $table_row_retired) {
							echo "<tr class='text-muted'>";
							echo "  <td><a href='" . $table_row_retired["project_home_link"] . "'>" . $table_row_retired["project_name"];
							echo "	</a></td>";
							echo "<td>";
							echo "<a href='" . $table_row_retired["project_link"] . "'>";
							echo "<i class='fa fa-bar-chart'></i>";
							echo "</a>";
							echo "</td>";
							echo "  <td><b>" . number_format($table_row_retired["total_credits"], 0, $dec_point, $thousands_sep) . "</b></td>";
							echo "<td class='hidden-xs hidden-sm'>" . number_format($table_row_retired["proz_anteil"], 2, $dec_point, $thousands_sep) . "</td>";
							echo "<td class='hidden-xs'></td>";
							echo "<td class='hidden-xs hidden-sm'></td>";
							echo "<td class='hidden-xs hidden-sm'></td>";
							echo "<td class='hidden-xs'></td>";
							echo "<td class='success'></td>";
							echo "<td class='info'></td>";
							echo "<td class='danger hidden-xs'></td>";
							echo "</tr>";
						}
					?>
					<tr class="alert-info">
						<td><b><?php echo $tr_th_total ?></b></td>
						<td><b><?php #echo $tr_th_detail ?></b></td>
						<td><b><?php echo number_format($sum_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="hidden-xs hidden-sm"><b>100%</b></td>
						<td class="hidden-xs">
						<b><?php echo number_format($sum1h_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="hidden-xs hidden-sm">
						<b><?php echo number_format($sum2h_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="hidden-xs hidden-sm">
						<b><?php echo number_format($sum6h_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="hidden-xs">
						<b><?php echo number_format($sum12h_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="alert-success">
						<b><?php echo number_format($sum_today_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="alert-info">
						<b><?php echo number_format($sum_yesterday_total, 0, $dec_point, $thousands_sep) ?></b></td>
						<td class="alert-danger hidden-xs">
						<b><?php echo number_format($sum_pendings, 0, $dec_point, $thousands_sep) ?></b></td>
					</tr>
					<tr class="default">
						<td></td>
						<td><?php #echo $tr_tb_det ?></td>
						<td><?php #echo $tr_tb_cr ?></td>
						<td class="hidden-xs hidden-sm"></td>
						<td class="hidden-xs"><?php echo $tr_tb_01 ?></td>
						<td class="hidden-xs hidden-sm"><?php echo $tr_tb_02 ?></td>
						<td class="hidden-xs hidden-sm"><?php echo $tr_tb_06 ?></td>
						<td class="hidden-xs"><?php echo $tr_tb_12 ?></td>
						<td class="alert-success"><b><?php echo $tr_tb_to ?></b></td>
						<td class="alert-info"><b><?php echo $tr_tb_ye ?></b></td>
						<td class="alert-danger hidden-xs"><b><?php echo $tr_tb_pe ?></b></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	
	<div id="pie" class="tab-pane fade">
		<div class="section text-center section-default">
			<div class="container-fluid">
				<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
					<div id="projektverteilung"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="gesamt" class="tab-pane fade">
		<div class="section text-center section-default">
			<div class="container-fluid">
				<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
					<div id="output"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="stunde" class="tab-pane fade">
		<div class="section text-center section-default">
			<div class="container-fluid">
				<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
					<div id="output_gesamt_hour"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="tag" class="tab-pane fade">
		<div class="section text-center section-default">
			<div class="container-fluid">
				<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
					<div id="output_gesamt_day"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="woche" class="tab-pane fade">
		<div class="section text-center section-default">
			<div class="container-fluid">
				<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
					<div id="output_gesamt_week"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="monat" class="tab-pane fade">
		<div class="section text-center section-default">
			<div class="container-fluid">
				<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
					<div id="output_gesamt_month"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="jahr" class="tab-pane fade">
		<div class="section text-center section-default">
			<div class="container-fluid">
				<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
					<div id="output_gesamt_year"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="badges" class="tab-pane fade">
		<div class="section text-center section-default">
			<div class="container-fluid">
				<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
					<br>
					<?php //Userbadge
						if ( $userbadges ) {
							echo '<img src="' . $link_user_badges . '" class="img-responsive center-block"></img>';
						} else echo $no_badge;
					?>
					<br>
					<?php //WCG-Badge
						if ( $wcglogo ) {
							echo '<img src="' . $link_wcg_sig . '" class="img-responsive center-block"></img>';
						} else echo $no_wcg_badge;
					?>
					<?php //WCG-SG-Badges
						if ($sgwcgbadges == "1") {
							echo '<img src="' . $link_sg_wcg_badges . '" class="img-responsive center-block"></img>';
						} else echo $no_sg_wcg_badge;
					?>					
					<br>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo "$tr_hp_footer" ?>

</body>
</html>