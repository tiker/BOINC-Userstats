<?php

include "./settings/settings.php";

// Sprachdefinierung
if (isset($_GET["lang"])) $lang = $_GET["lang"];
else $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));

# Auswahl der Sprache, wenn nicht vorhanden, Nutzung von englischer Sprachdatei
if (file_exists("./lang/" . $lang . ".txt.php")) include "./lang/" . $lang . ".txt.php";
else include "./lang/en.txt.php";

############################################################
# Beginn fuer Datenzusammenstellung User
$query_getUserData = mysqli_query($db_conn, "SELECT * from boinc_user"); //alle Userdaten einlesen
if ( !$query_getUserData ) { 	
	$connErrorTitle = "Datenbankfehler";
	$connErrorDescription = "Es wurden keine Werte zurückgegeben.</br>
							Es bestehen wohl Probleme mit der Datenbankanbindung.";
	include "./errordocs/db_initial_err.php";
	exit();
} elseif ( mysqli_num_rows($query_getUserData) === 0 ) { 
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
?>

<?php echo $html_head; ?>

</head>
<body>
<div class="wrapper force_min_height">
	<?php if ( $showNavbar ) echo $html_nav ?>
	<!--div class="landing-header"-->
	<div class="header img-reponsive" style="background-image: url('<?php echo $header_backround_url ?>');">
		<div class="container">
			<div class="motto">
				<h1 class="title" style="color: white;"><?php echo "$tr_th_bp" ?></h1>
				<h3>
					<font color="white"><?php echo "$boinc_username" . " " . $tr_th_ot . " " . $boinc_teamname ?></font>
				</h3>
				
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

	<div class="container text-center  flex1">
		<h1 class="title"><?php echo $connErrorTitle; ?></h1>
		<h5 class="description text-center"><?php echo $connErrorDescription; ?></h5>					
	</div>

	<?php echo "$html_footer" ?>

</div>
</body>
</html>
