<?php
	include "./settings/settings.php";
	date_default_timezone_set('UTC');
	//-----------------------------------------------------------------------------------
	// ab hier bitte keine Aenderungen vornehmen, wenn man nicht weiß, was man tut!!! :D
	//-----------------------------------------------------------------------------------
	
	// Sprachdefinierung
	if(isset($_GET["lang"])) $lang=$_GET["lang"];
	else $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2));
	
	//Variablen initialisieren
	$sum1h_total = 0;
	$sum2h_total = 0;
	$sum6h_total = 0;
	$sum12h_total = 0;
	$sum_today_total = 0;
	$sum_yesterday_total = 0;

	$goon = false;
	$projectid = addslashes($_GET["projectid"]);
	$query_check = mysqli_query($db_conn,"SELECT project_shortname FROM boinc_grundwerte" );
	if ( !$query_check ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es konnte keine Verbindung zur Datenbank aufgebaut werden.";
		include "./errordocs/db_initial_err.php";
		exit();
	} elseif  ( mysqli_num_rows($query_check) === 0 ) { 
		$connErrorTitle = "Fehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Offenbar existieren keine Werte in deiner Datenbank";
		include "./errordocs/db_initial_err.php";
		exit();	
	}

	while ( $row = mysqli_fetch_assoc($query_check) ) {
		$project_check = $row["project_shortname"];
		if ( $project_check === $projectid ) { 
			$goon = true;
		}
	};
	
	if ( !$goon ) {
		$connErrorTitle = "Fehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Das Projekt existiert offenbar nicht in der Datenbank.";
		include "./errordocs/db_initial_err.php";
		exit();
	} 

	
	############################################################
	# Beginn fuer Datenzusammenstellung User
	$query_getUserData=mysqli_query($db_conn,"SELECT * from boinc_user");  //alle Userdaten einlesen
	if ( !$query_getUserData || mysqli_num_rows($query_getUserData) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	# und hier geht es nun weiter, wenn die Abfrage erwartete Werte liefert.
	while($row=mysqli_fetch_assoc($query_getUserData)){
		$project_username = $row["boinc_name"];
		$project_wcgname = $row["wcg_name"];
		$wcg_verification = $row["wcg_verificationkey"];
		$project_teamname = $row["team_name"];
		$cpid = $row["cpid"];
		$datum_start = $row["lastupdate_start"];
		$datum = $row["lastupdate"];
	}
	
	$lastupdate_start = date("d.m.Y H:i:s",$datum_start);
	$lastupdate = date("H:i:s",$datum);
	# Ende Datenzusammenstellung User
	############################################################
	
	############################################################
	# Beginn fuer Datenzusammenstellung Projekt
	$query_getProjectData =mysqli_query($db_conn,"SELECT * FROM boinc_grundwerte WHERE project_shortname = '$projectid'") or die(mysqli_error());
	if ( !$query_getProjectData || mysqli_num_rows($query_getProjectData) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	# und hier geht es nun weiter, wenn die Abfrage erwartete Werte liefert.	
	$row = mysqli_fetch_assoc($query_getProjectData);
	$projectname = $row['project'];
	$projectuserid = $row['project_userid'];
	#$start_time = $row['start_time'];
	$status = $row['project_status'];
	$minimum = $row['begin_credits'];
	$output_project_html = "";
	$output_project_gesamt_pendings_html = "";
	$output_project_gesamt_html = "";
	$query_getProjectOutputPerHour=mysqli_query($db_conn,"SELECT time_stamp, credits from boinc_werte where project_shortname='" .$projectid. "'");
	if ( !$query_getProjectOutputPerHour || mysqli_num_rows($query_getProjectOutputPerHour) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	while($row=mysqli_fetch_assoc($query_getProjectOutputPerHour)){
		$timestamp = ($row["time_stamp"]) * 1000;
		$output_project_html.= "[(" .$timestamp. "), " .$row["credits"]. "], ";	
	}
	$output_project_html=substr($output_project_html,0,-2);
	
	$query_getProjectOutputPerDay=mysqli_query($db_conn,"SELECT time_stamp, total_credits, pending_credits from boinc_werte_day where project_shortname='" .$projectid. "'");
	if ( !$query_getProjectOutputPerDay || mysqli_num_rows($query_getProjectOutputPerDay) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	while($row=mysqli_fetch_assoc($query_getProjectOutputPerDay)){
		$timestamp1 = ($row["time_stamp"]) * 1000;
		$output_project_gesamt_html.= "[(" .$timestamp1. "), " .$row["total_credits"]. "], ";	
		$output_project_gesamt_pendings_html.= "[(" .$timestamp1. "), " .$row["pending_credits"]. "], ";
	}
	$output_project_gesamt_html=substr($output_project_gesamt_html,0,-2);
	$output_project_gesamt_pendings_html=substr($output_project_gesamt_pendings_html,0,-2);
	#
	# Ende Datenzusammenstellung Projekt
	############################################################	
	
	$einsh = mktime(date("H"), 0, 0, date("m"), date ("d"), date("Y"));
	$zweih = mktime(date("H")-1, 0, 0, date("m"), date ("d"), date("Y"));
	$sechsh = mktime(date("H")-5, 0, 0, date("m"), date ("d"), date("Y"));
	$zwoelfh= mktime(date("H")-11, 0, 0, date("m"), date ("d"), date("Y"));
	
	#####################################
	# Daten fuer Tabelle holen
	$query_getProjetData=mysqli_query($db_conn,"SELECT * from boinc_grundwerte where project_shortname = '$projectid'");  //alle Projektgrunddaten einlesen
	if ( !$query_getProjetData || mysqli_num_rows($query_getProjetData) === 0 ) { 
		$connErrorTitle = "Datenbankfehler";
		$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
								Es bestehen wohl Probleme mit der Datenbankanbindung.";
		include "./errordocs/db_initial_err.php";
		exit();
	}
	while($row=mysqli_fetch_assoc($query_getProjetData)){
		
		############################################################
		# Daten fuer Tabelle zuammenstellen
		$shortname=$row["project_shortname"];
		$table_row["project_name"]=$row["project"];
		$table_row["total_credits"]=$row["total_credits"];
		$table_row["project_status"]=$row["project_status"];
		$pstatus=$row["project_status"];
		$table_row["pending_credits"]=$row["pending_credits"];
		$table_row["project_home_link"]=$row["project_homepage_url"];
		$table_row["user_stats_vorhanden"]=$row["project_status"];
		
		#Daten fuer letzte Stunde holen
		$query_getProjectOutput1h = mysqli_query($db_conn,"SELECT sum(credits) AS sum1h FROM boinc_werte WHERE project_shortname='" .$shortname. "' and time_stamp>'" .$einsh. "'");
		if ( !$query_getProjectOutput1h || mysqli_num_rows($query_getProjectOutput1h) === 0 ) {
			$connErrorTitle = "Datenbankfehler";
			$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
									Es bestehen wohl Probleme mit der Datenbankanbindung.";
			include "./errordocs/db_initial_err.php";
			exit();
		}
		$row2 = mysqli_fetch_assoc($query_getProjectOutput1h);
		$table_row["sum1h"] = $row2["sum1h"];
		$sum1h_total += $table_row["sum1h"];
		
		#Daten der letzten 2 Stunden holen
		$query_getProjectOutput2h = mysqli_query($db_conn,"SELECT sum(credits) AS sum2h FROM boinc_werte WHERE project_shortname='" .$shortname. "' and time_stamp>'" .$zweih. "'");
		if ( !$query_getProjectOutput2h || mysqli_num_rows($query_getProjectOutput2h) === 0 ) { 
			$connErrorTitle = "Datenbankfehler";
			$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
									Es bestehen wohl Probleme mit der Datenbankanbindung.";
			include "./errordocs/db_initial_err.php";
			exit();
		}
		$row2 = mysqli_fetch_assoc($query_getProjectOutput2h);
		$table_row["sum2h"] = $row2["sum2h"];
		$sum2h_total += $table_row["sum2h"];
		
		#Daten der letzten 6 Stunden holen
		$query_getProjectOutput6h = mysqli_query($db_conn,"SELECT sum(credits) AS sum6h FROM boinc_werte WHERE project_shortname='" .$shortname. "' and time_stamp>'" .$sechsh. "'");
		if ( !$query_getProjectOutput6h  || mysqli_num_rows($query_getProjectOutput6h) === 0 ) { 
			$connErrorTitle = "Datenbankfehler";
			$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
									Es bestehen wohl Probleme mit der Datenbankanbindung.";
			include "./errordocs/db_initial_err.php";
			exit();
		}
		$row2 = mysqli_fetch_assoc($query_getProjectOutput6h);
		$table_row["sum6h"] = $row2["sum6h"];
		$sum6h_total += $table_row["sum6h"];
		
		#Daten der letzten 12 Stunden holen
		$query_getProjectOutput12h = mysqli_query($db_conn,"SELECT sum(credits) AS sum12h FROM boinc_werte WHERE project_shortname='" .$shortname. "' and time_stamp>'" .$zwoelfh. "'");
		if ( !$query_getProjectOutput12h || mysqli_num_rows($query_getProjectOutput12h) === 0 ) { 
			$connErrorTitle = "Datenbankfehler";
			$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
									Es bestehen wohl Probleme mit der Datenbankanbindung.";
			include "./errordocs/db_initial_err.php";
			exit();
		} 
		$row2 = mysqli_fetch_assoc($query_getProjectOutput12h);
		$table_row["sum12h"] = $row2["sum12h"];
		$sum12h_total += $table_row["sum12h"];
		
		#Aktueller Tagesoutput
		$tagesanfang = mktime(0, 0, 0, date("m"), date ("d"), date("Y"));
		$query_getProjectOutputToday = mysqli_query($db_conn,"SELECT sum(credits) AS sum_today FROM boinc_werte WHERE project_shortname='" .$shortname. "' and time_stamp>'" .$tagesanfang. "'");
		if ( !$query_getProjectOutputToday || mysqli_num_rows($query_getProjectOutputToday) === 0 ) { 
			$connErrorTitle = "Datenbankfehler";
			$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
									Es bestehen wohl Probleme mit der Datenbankanbindung.";
			include "./errordocs/db_initial_err.php";
			exit();
		}
		$row2 = mysqli_fetch_assoc($query_getProjectOutputToday);
		$table_row["sum_today"] = $row2["sum_today"];
		$sum_today_total += $table_row["sum_today"];
		
		#Tagesoutput gestern
		$gestern_anfang = mktime(0, 0, 1, date("m"), date ("d")-1, date("Y"));
		$gestern_ende = mktime(0, 0, 0, date("m"), date ("d"), date("Y"));
		$query_getProjectOutputYesterday = mysqli_query($db_conn,"SELECT sum(credits) AS sum_yesterday FROM boinc_werte WHERE project_shortname='" .$shortname. "' AND time_stamp BETWEEN '" .$gestern_anfang. "' AND '" .$gestern_ende. "'");
		if ( !$query_getProjectOutputYesterday || mysqli_num_rows($query_getProjectOutputYesterday) === 0 ) { 
			$connErrorTitle = "Datenbankfehler";
			$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
									Es bestehen wohl Probleme mit der Datenbankanbindung.";
			include "./errordocs/db_initial_err.php";
			exit();
		}
		$row2 = mysqli_fetch_assoc($query_getProjectOutputYesterday);
		$table_row["sum_yesterday"] = $row2["sum_yesterday"];
		$sum_yesterday_total += $table_row["sum_yesterday"];
		
		$table_row["project_link"]= "project.php?projectid=" .$shortname. "";
		
		$table[]=$table_row;
		# Ende Datenzusammenstellung fuer Tabelle
	}
	# Ende Datenzusammenstellung fuer Tabelle
	##########################################
	if (file_exists("./lang/" .$lang. ".txt.php")) include "./lang/" .$lang. ".txt.php";
	else include "./lang/en.txt.php";
?>

<!-- ########################################-->
<!-- Beginn der HTML-Seite mit Diagrammen -->

<!-- HTML-Header -->
<?php echo $tr_hp_header ?>
	<style>
        .force_min_height {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .flex1 {
            flex: 1;
        }
    </style>
<?php
if (file_exists("./lang/highstock_" . $lang . ".js")) include "./lang/highstock_" . $lang . ".js";
else include "./lang/highstock_en.js";
?>

<!-- Highcharts definieren  -->
<?php include("./charts/project_output.js"); ?>
<?php include("./charts/project_output_hour.js"); ?>
<?php include("./charts/project_output_day.js"); ?>
<?php include("./charts/project_output_week.js"); ?>
<?php include("./charts/project_output_month.js"); ?>
<?php include("./charts/project_output_year.js"); ?>

</head>

<body>
	
	<?php if ( $showNavbar ) echo $tr_hp_nav ?>
	
	<div class="wrapper force_min_height">
		<div class="header img-reponsive" style="background-image: url('<?php echo $header_backround_url ?>');">
			<div class="container">
				<div class="motto">
					<h1 class="title"><font color="white"><?php echo $table_row['project_name']; ?></font></h1>
					<h3><font color="white"><?php echo "$project_of" . " " . "$project_username" . " " . "$tr_th_ot" . " " . "$project_teamname" ?></font></h3>

					<?php //sind laufende WUs im Internet ersichtlich
						if ( $hasBoinctasks ) {
							echo '<a href="' . $linkBoinctasks . '" class="btn btn-neutral btn-simple"><i class="fa fa-tasks"></i> ' . $linkNameBoinctasks . '</a>';
						};
					?>
					
					<?php //Link zu Boinctasks
						if ( $hasBoincstats ) {
							echo '<a href="' . $linkBoincstats . '" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-bar-chart"></i> ' . $linkNameBoincstats . '</a>';
						};
					?>
					<br/>
					<?php //Link zu Team
						if ( $hasTeamHp ) {
							echo '<a href="' . $teamHpURL . '" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-link"></i> ' . $teamHpName . '</a>';
						};
					?>
					
					<?php //Link zu WCG
						if ( $hasWcg ) {
							echo '<a href="' . $linkWcg . '" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-globe"></i> ' . $linkNameWcg . '</a>';
						};
					?>

					<?php //Pendings
						if ( $hasPendings ) {
							echo '<a href="' . $linkPendings . '" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-refresh"></i> ' . $linkNamePendings . '</a>';
						};
					?>
					
				</div>
			</div>    
		</div>
		
		
		<div class="alert-info">
			<div class="container">
				<h5><?php echo $tr_th_lu ?>: <?php echo $lastupdate_start ?> - <?php echo $lastupdate ?> (UTC)</h5> <!--a href="index.php"><i class="pull-right fa fa-home align-right"></i></a-->
			</div>
		</div>
		
		
		<div class="alert-warning">		
			<div class="container"><a href='index.php'><i class='fa fa-home fa-fw'></i>Home</a> <i class="fa fa-arrow-right fa-fw"></i><i class='fa fa-bar-chart fa-fw'></i><?php echo "$project_project" ?>: <?php echo $table_row['project_name']; ?>
			</div>
		</div>
		
		<div class="nav-tabs-navigation">
			<div class="nav-tabs-wrapper">
				<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
					<li class="active"><a data-toggle="tab" href="#projekte"><i class="fa fa-table"></i> <?php echo "$tabs_project" ?></a></li>
					<li><a data-toggle="tab" href="#gesamt"><i class="fa fa-area-chart"></i> <?php echo "$tabs_total" ?></a></li>
					<li><a data-toggle="tab" href="#stunde"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_hour" ?></a></li>
					<li><a data-toggle="tab" href="#tag"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_day" ?></a></li>
					<li><a data-toggle="tab" href="#woche"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_week" ?></a></li>
					<li><a data-toggle="tab" href="#monat"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_month" ?></a></li>
					<li><a data-toggle="tab" href="#jahr"><i class="fa fa-bar-chart"></i> <?php echo "$tabs_year" ?></a></li>
					<li><a data-toggle="tab" href="#badges"><i class="fa fa-certificate"></i> <?php echo "$tabs_badge" ?></a></li>
				</ul>
			</div>
		</div>

		<!--style>@media (max-width: 978px) { .table-condensed td, .table-condensed th { padding: 0 1px !important; } }</style-->
					
		<style>
			@media (max-width: 767px) {
				.table-condensed td,
				.table-condensed th {
					padding: 3px 5px !important;
				}
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
		
		
		<div class="tab-content text-center flex1">
			<div id="projekte" class="tab-pane fade in active">		
				<div class="section text-center section-default">
					<div class="container-fluid">
						<table class="table table-striped table-hover text-right" style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
							<thead> 
								<tr>
									<th class="text-right"><?php echo "$project_project" ?></th>
									<th class="text-right"><?php echo "$tr_tb_cr" ?></th>
									<th class="hidden-xs text-right"><?php echo "$tr_tb_01" ?></th>
									<th class="hidden-xs hidden-sm text-right"><?php echo "$tr_tb_02" ?></th>
									<th class="hidden-xs hidden-sm text-right"><?php echo "$tr_tb_06" ?></th>
									<th class="hidden-xs text-right"><?php echo "$tr_tb_12" ?></th>
									<th class="alert-success text-right"><?php echo "$tr_tb_to" ?></th>
									<th class="alert-info text-right"><?php echo "$tr_tb_ye" ?></th>
									<th class="hidden-xs alert-danger text-right"><?php echo "$tr_tb_pe" ?></th>
								</tr>
							</thead>
							<tbody>
								<!-- Fuer jedes Projekt eine Zeile in die Tabelle hinzufuegen -->
								<?php
									foreach($table as $table_row){
										echo "<tr>";
										echo "  <td>";
										echo "	<a href='" .$table_row["project_home_link"] . "'>" .$table_row["project_name"];
										echo "	</a>";
										if ($table_row["project_name"] == "World Community Grid" || $table_row["project_name"] == "WCG") {
											if ($wcg_verification === NULL || $wcg_verification === "") {
												echo ""; } else {
												echo "  <a href class='primary' data-toggle='modal' data-target='#modalwcgdetail'><i class='fa fa-list'></i></a>";
											}           
										} 
										echo "  <td>" .number_format($table_row["total_credits"],0,$dec_point,$thousands_sep). "</td>";
										echo "  <td class='hidden-xs'>" .number_format($table_row["sum1h"],0,$dec_point,$thousands_sep). "</td>";
										echo "  <td class='hidden-xs hidden-sm'>" .number_format($table_row["sum2h"],0,$dec_point,$thousands_sep). "</td>";
										echo "  <td class='hidden-xs hidden-sm'>" .number_format($table_row["sum6h"],0,$dec_point,$thousands_sep). "</td>";
										echo "  <td class='hidden-xs'>" .number_format($table_row["sum12h"],0,$dec_point,$thousands_sep). "</td>";
										echo "  <td class='success text-success'>" .number_format($table_row["sum_today"],0,$dec_point,$thousands_sep). "</td>";
										echo "  <td class='info text-info'>" .number_format($table_row["sum_yesterday"],0,$dec_point,$thousands_sep). "</td>";
										echo "  <td class='hidden-xs danger text-danger'>" .number_format($table_row["pending_credits"],0,$dec_point,$thousands_sep). "</td>";
										echo "</tr>";
									}
								?>
							</table>
						</div>
					</div>
				</div>
		
				<!-- Highchart-Container hinzufuegen -->
				<div id="gesamt" class="tab-pane fade">
					<div class="section text-center section-default">
						<div class="container-fluid">
							<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
								<div id="project_output"></div>
							</div>
						</div>
					</div>
				</div>
				
				<div id="stunde" class="tab-pane fade">
					<div class="section text-center section-default">
						<div class="container-fluid">
							<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
								<div id="project_output_hour"></div>
							</div>
						</div>
					</div>
				</div>
				
				<div id="tag" class="tab-pane fade">
					<div class="section text-center section-default">
						<div class="container-fluid">
							<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
								<div id="project_output_day"></div>
							</div>
						</div>
					</div>
				</div>
				
				<div id="woche" class="tab-pane fade">
					<div class="section text-center section-default">
						<div class="container-fluid">
							<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
								<div id="project_output_week"></div>
							</div>
						</div>
					</div>
				</div>
				
				<div id="monat" class="tab-pane fade">
					<div class="section text-center section-default">
						<div class="container-fluid">
							<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
								<div id="project_output_month"></div>
							</div>
						</div>
					</div>
				</div>
				
				<div id="jahr" class="tab-pane fade">
					<div class="section text-center section-default">
						<div class="container-fluid">
							<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
								<div id="project_output_year"></div>
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
									if ($showUserBadges == "1") {
										echo '<img src="' . $linkUserBadges . '" class="img-responsive center-block"></img>';
									} elseif ($showWcgLogo == "1") {
										echo '<img src="' . $linkWcgSig . '" class="img-responsive center-block"></img>';
									} elseif ($showSgWcgBadges == "1") {
										echo '<img src="' . $linkSgWcgBadges . '" class="img-responsive center-block"></img>';
									} else echo $no_badge;
								?>
								<br>
							</div>
						</div>
					</div>		
				</div>
			</div>
			
			<?php echo "$tr_hp_footer" ?>

			<!-- WCG-Detail-Statistik modal hinzufuegen -->
			<div class="modal fade" id="modalwcgdetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content ">
						<div class="modal-header section-default">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="modelTitleId"><?php echo "$project_wcg_detail_link" ?></h4>
						</div>
						<div class="modal-body section-default">
							<div style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
								<div id="file-content"><?php include './wcg_detail_html.php'; ?></div>
							</div>
						</div>
						<div class="modal-footer section-default">
							<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">OK</button>
						</div>
					</div>
				</div>
			</div>  

		</body>
	</html>
