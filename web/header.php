<!doctype html>
<html lang="<?php echo $lang; ?>">
	<head>
		<title><?php echo $text_hp_title; ?></title>

		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Layout Standard CSS Bootstrap & DataTables -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.3/css/fixedHeader.dataTables.min.css">

		<!--  Fonts and icons  -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
		<link href="https://cdn.datatables.net/plug-ins/1.10.16/integration/font-awesome/dataTables.fontAwesome.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">

		<!--  JavaScript -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<script src="https://code.highcharts.com/stock/highstock.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
		<script src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>

		<!-- Layout CSS for Userstats-->
		<link rel="stylesheet" href="./assets/css/userstats_layout.css">
		<link rel="stylesheet" href="./assets/css/userstats_style.css"> 

	</head>
	
	<body>
		<?php if ( $showNavbar ) include("./nav.php"); ?>
			<div class = "force_min_height">
				<div class="jumbotron jumbotron-fluid" style="background-image: url('<?php echo $header_backround_url; ?>');">
					<div class="container">
						<div class="d-inline-flex flex-column" style="background: rgba(255, 255, 255, 0.3); border-radius: 12px; padding: 12px; border: 1px solid #d3d3d3">
							<?php if ($showProjectHeader) { echo '
									<h1 class="title"><font color="white">' . $projectname . '</font></h1>
							';} else if ($showPendingsHeader) { echo '
								<h1 class="title"><font color="white">' . $text_header_pendings . '</font></h1>
							';} else { echo '
								<h1 class="title"><font color="white">' . $text_header_motto .  '</font></h1>
							';};
							?>
							<h3><font color="white"><?php echo "$boinc_username" . " <font size='3'> " . $text_header_ot . "</font> " . $boinc_teamname ?></font></h3>
							
							<?php 
								//sind laufende WUs im Internet ersichtlich
#								if ( $hasBoinctasks ) {
#									echo '<a href="' . $linkBoinctasks . '" class="btn btn-neutral btn-simple"><i class="fa fa-tasks"></i> ' . $linkNameBoinctasks . '</a>';
#								};
								//Link zu Boinctasks
#								if ( $hasBoincstats ) {
#									echo '<a href="' . $linkBoincstats . '" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-bar-chart"></i> ' . $linkNameBoincstats . '</a>';
#								};
								//Link zu Team
#								if ( $hasTeamHp ) {
#									echo '<a href="' . $teamHpURL . '" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-link"></i> ' . $teamHpName . '</a>';
#								};
								//Link zu WCG
#								if ( $hasWcg ) {
#									echo '<a href="' . $linkWcg . '" target="_new" class="btn btn-neutral btn-simple"><i class="fa fa-globe"></i> ' . $linkNameWcg . '</a>';
#								};
								//Pendings
#								if ( $hasPendings ) {
#									echo '<a href="' . $linkPendings . '" class="btn btn-neutral btn-simple"><i class="fa fa-refresh"></i> ' . $linkNamePendings . '</a>';
#								};
							?>
						</div>
					</div>
				</div>
