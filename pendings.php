<?php
	include "./settings/settings.php";
	date_default_timezone_set('UTC');
	//-----------------------------------------------------------------------------------
	// ab hier bitte keine Aenderungen vornehmen, wenn man nicht weiß, was man tut!!! :D
	//-----------------------------------------------------------------------------------
	
	// Sprachdefinierung
	if (isset($_GET["lang"])) $lang = $_GET["lang"];
	else $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2));
	
	############################################################
	# Beginn fuer Datenzusammenstellung User
	$result_user = mysqli_query($db_conn, "SELECT * FROM boinc_user");  //alle Userdaten einlesen
	while ($row = mysqli_fetch_assoc($result_user)) {
		$project_username = $row["boinc_name"];
		$project_wcgname = $row["wcg_name"];
		$project_teamname = $row["team_name"];
		$cpid = $row["cpid"];
		$datum_start = $row["lastupdate_start"];
		$datum = $row["lastupdate"];
	}
	$lastupdate_start = date("d.m.Y H:i:s",$datum_start);
	$lastupdate = date("H:i:s",$datum);
	# Ende Datenzusammenstellung User
	
	$pending_credits = "0";
	if (file_exists("./lang/" .$lang. ".txt.php")) include "./lang/" .$lang. ".txt.php";
	else include "./lang/en.txt.php";
	
?>

<?php echo $tr_hp_header ?>

</head>

<body>
	
	<?php if ( $navbar ) echo $tr_hp_nav ?>
	
	<div class="wrapper">
		<!--div class="landing-header"-->
		<div class="header img-reponsive" style="background-image: url('<?php echo $header_backround_url ?>');">
			<div class="container">
				<div class="motto">
					<h1 class="title"><font color="white"><?php echo "$tr_th_bp" ?></font></h1>
					<h3><font color="white"><?php echo "$project_username" . " " . $tr_th_ot . " " . $project_teamname ?></font></h3>
					<br />
					<a href="../index.html#uebermich" class="btn btn-neutral"><i class="fa fa-male fa-lg"></i> über mich...</a>
					<a href="../index.html#projekte" class="btn btn-neutral"><i class="fa fa-wrench fa-lg"></i> meine Web-Projekte</a>
					<br /><br />
					<h3><font color="white">Weitere Links</font></h3>
					<a href="https://seti-germany.de" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-link"></i> SETI.Germany</a>
					<a href="https://boincstats.com/de/stats/-5/user/detail/865/projectList" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-bar-chart"></i> BoincStats</a>
					<a href="https://join.worldcommunitygrid.org?recruiterId=653215&teamId=4VVG5BDPP1" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-globe"></i> World Community Grid</a>
				</div>
			</div>    
		</div>
	</div>
	
	
	<div class="section text-center section-default">
		<div class="container">
			<div class="main">
				<div class="section section-standard">
					<div class="container">
						<h2 class="title-uppercase text-center">Pending Credits</h2>
						<div class="alert alert-success">
							<div class="container">
								<?php echo $tr_hp_pendings_02; ?>
								
							</div>
						</div>
						<table class="table table-striped table-hover text-right table-condensed"
						style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
							
							<thead>
								<tr>
									<th class="text-right"><?php echo $tr_tb_pr ?></th>
									<th class="text-left"><?php echo $tr_tb_pe ?></th>
								</tr>
							</thead>
							<tbody>
								
								<?php
									$query = mysqli_query($db_conn, "SELECT * FROM boinc_grundwerte WHERE project_status = 1;") or die (mysqli_error);  //nur bei aktiven Projekten Werte lesen
									$ctx = stream_context_create(array(
									'http' => array(
									'timeout' => 1
									)
									)
									);
									$xml_string_pendings = "false";
									$pendings_gesamt = null;
									while ($row = mysqli_fetch_assoc($query)) {
										$xml_string_pendings = @file_get_contents($row['url'] . "pending.php?format=xml&authenticator=" . $row['authenticator'], 0, $ctx);
										if ($xml_string_pendings == FALSE) {
											$projectname = $row['project'];
											$pending_credits = $row['pending_credits'];
											} else {
											$projectname = $row['project'];
											$xml_pendings = @simplexml_load_string($xml_string_pendings);
											$pending_credits = intval($xml_pendings->total_claimed_credit);
										}
										$pendings_gesamt = $pendings_gesamt + $pending_credits;
										$sql_pendings = "UPDATE boinc_grundwerte SET pending_credits='" . $pending_credits . "' WHERE project_shortname='" . $row['project_shortname'] . "'";   //aktuelle Pendings des Projektes in Grundwerttabelle eintragen
										mysqli_query($db_conn, $sql_pendings);  //Werte in DB eintragen
										
										echo "  <tr><td class='text-right'>" . $projectname . "</td>";
										echo "  <td class='text-left'>" . number_format($pending_credits, 0, $dec_point, $thousands_sep) . "</td></tr>";
									}
									echo "  <tr><td class='text-right'>GESAMT Pendings</td>";
									echo "  <td class='text-left'>" . number_format($pendings_gesamt, 0, $dec_point, $thousands_sep) . "</td></tr>";
								?>
							</tbody>
						</table>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
<?php echo "$tr_hp_footer" ?>
</body>
</html>
