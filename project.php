<?php
	include "./settings/settings.php";
	date_default_timezone_set('UTC');
	//-----------------------------------------------------------------------------------
	// ab hier bitte keine Aenderungen vornehmen, wenn man nicht weiß, was man tut!!! :D
	//-----------------------------------------------------------------------------------
	
	// Sprachdefinierung
	if(isset($_GET["lang"])) $lang=$_GET["lang"];
	else $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2));
	
	$goon = false;
	$projectid = addslashes($_GET["projectid"]);
	$query_check = mysqli_query($db_conn,"SELECT project_shortname FROM boinc_grundwerte" ) or die(mysql_error());
	
	while ( $row = mysqli_fetch_assoc($query_check) ) {
		$project_check = $row["project_shortname"];
		if ( $project_check === $projectid ) { $goon = true; }
	};
	
	if ( !$goon ) { die("No valid Project-ID"); } 
	
	
	############################################################
	# Beginn fuer Datenzusammenstellung User
	$result_user=mysqli_query($db_conn,"SELECT * from boinc_user");  //alle Userdaten einlesen
	while($row=mysqli_fetch_assoc($result_user)){
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
	$query =mysqli_query($db_conn,"SELECT * FROM boinc_grundwerte WHERE project_shortname = '$projectid'") or die(mysqli_error());
	$row = mysqli_fetch_assoc($query);
	$projectname = $row['project'];
	$projectuserid = $row['project_userid'];
	$start_time = $row['start_time'];
	$status = $row['project_status'];
	$minimum = $row['begin_credits'];
	$output_project_html = null;
	$output_project_gesamt_pendings_html = null;
	$output_project_gesamt_html = null;
	$result_project_output=mysqli_query($db_conn,"SELECT time_stamp, credits from boinc_werte where project_shortname='" .$projectid. "'");
	while($row=mysqli_fetch_assoc($result_project_output)){
		$timestamp = ($row["time_stamp"]) * 1000;
		$output_project_html.= "[(" .$timestamp. "), " .$row["credits"]. "], ";
		
	}
	$output_project_html=substr($output_project_html,0,-2);
	
	$result_project_output_gesamt=mysqli_query($db_conn,"SELECT time_stamp, total_credits, pending_credits from boinc_werte_day where project_shortname='" .$projectid. "'");
	while($row=mysqli_fetch_assoc($result_project_output_gesamt)){
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
	$result_grundwerte=mysqli_query($db_conn,"SELECT * from boinc_grundwerte where project_shortname = '$projectid'");  //alle Projektgrunddaten einlesen
	while($row=mysqli_fetch_assoc($result_grundwerte)){
		
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
		$query='select sum(credits) as sum1h from boinc_werte where project_shortname="' .$shortname. '" and time_stamp>"' .$einsh. '"';
		$result = mysqli_query($db_conn,$query);
		$row2 = mysqli_fetch_assoc($result);
		$table_row["sum1h"] = $row2["sum1h"];
		$sum1h_total += $table_row["sum1h"];
		
		#Daten der letzten 2 Stunden holen
		$query='select sum(credits) as sum2h from boinc_werte where project_shortname="' .$shortname. '" and time_stamp>"' .$zweih. '"';
		$result = mysqli_query($db_conn,$query);
		$row2 = mysqli_fetch_assoc($result);
		$table_row["sum2h"] = $row2["sum2h"];
		$sum2h_total += $table_row["sum2h"];
		
		#Daten der letzten 6 Stunden holen
		$query='select sum(credits) as sum6h from boinc_werte where project_shortname="' .$shortname. '" and time_stamp>"' .$sechsh. '"';
		$result = mysqli_query($db_conn,$query);
		$row2 = mysqli_fetch_assoc($result);
		$table_row["sum6h"] = $row2["sum6h"];
		$sum6h_total += $table_row["sum6h"];
		
		#Daten der letzten 12 Stunden holen
		$query='select sum(credits) as sum12h from boinc_werte where project_shortname="' .$shortname. '" and time_stamp>"' .$zwoelfh. '"';
		$result = mysqli_query($db_conn,$query);
		$row2 = mysqli_fetch_assoc($result);
		$table_row["sum12h"] = $row2["sum12h"];
		$sum12h_total += $table_row["sum12h"];
		
		#Aktueller Tagesoutput
		$tagesanfang = mktime(0, 0, 0, date("m"), date ("d"), date("Y"));
		$query='select sum(credits) as sum_today from boinc_werte where project_shortname="' .$shortname. '" and time_stamp>"' .$tagesanfang. '"';
		$result = mysqli_query($db_conn,$query);
		$row2 = mysqli_fetch_assoc($result);
		$table_row["sum_today"] = $row2["sum_today"];
		$sum_today_total += $table_row["sum_today"];
		
		#Tagesoutput gestern
		$gestern_anfang = mktime(0, 0, 1, date("m"), date ("d")-1, date("Y"));
		$gestern_ende = mktime(0, 0, 0, date("m"), date ("d"), date("Y"));
		$query='select sum(credits) as sum_yesterday from boinc_werte
		where	 project_shortname="' .$shortname. '" and 
		time_stamp between "' .$gestern_anfang. '" and "' .$gestern_ende. '"';
		$result = mysqli_query($db_conn,$query);
		$row2 = mysqli_fetch_assoc($result);
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

<!-- Highcharts definieren  -->
<?php include("./charts/project_output.js"); ?>
<?php include("./charts/project_output_hour.js"); ?>
<?php include("./charts/project_output_day.js"); ?>
<?php include("./charts/project_output_week.js"); ?>
<?php include("./charts/project_output_month.js"); ?>
<?php include("./charts/project_output_year.js"); ?>

</head>

<body>
	
	<?php if ( $navbar ) echo $tr_hp_nav ?>
	
	<div class="wrapper">
		<div class="header img-reponsive" style="background-image: url('<?php echo $header_backround_url ?>');">
			<div class="container">
				<div class="motto">
					<h1 class="title"><font color="white"><?php echo $table_row['project_name']; ?></font></h1>
					<h3><font color="white"><?php echo "$project_of" . " " . "$project_username" . " " . "$tr_th_ot" . " " . "$project_teamname" ?></font></h3>
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
		
		
		<div class="tab-content text-center">
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
									<th class="hidden-xs alert-danger text-right"><?php echo "$tr_tb_pe" ?><a class='text-alert' href='./pendings.php'><i class="fa fa-refresh"></i></a></th>
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
										if ($table_row["project_name"] == "World Community Grid") {
											if ($wcg_verification === NULL) {
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
									<div id="file-content"><? include './wcg_detail_html.php'; ?></div>
								</div>
							</div>
							<div class="modal-footer section-default">
								<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">OK</button>
							</div>
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
									if ($userbadges == "1") {
										echo '<img src="' . $link_user_badges . '" class="img-responsive center-block"></img>';
									} else echo $no_badge;
								?>	
								<br>
								<?php //WCG-Badge
									if ($wcglogo == "1") {
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
		