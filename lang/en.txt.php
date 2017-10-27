<?php
	// English version //
	$search = "Filter/Search";
	$tr_hp_title = "<title>Personal Userstats of " .$project_username. " from Team " .$project_teamname. "</title>";
	$tr_th_bp = "BOINC-Projects of";
	$tr_th_ot = "of team";
	$tr_th_lu = "last update";
	$tr_th_total = "Total";
	$tr_th_boinc_total = "BOINC combined";
	$tr_tb_pr = "active Project";
	$tr_tb_cr = "Credits";
	$tr_ch_week = "Week from";
	$tr_ch_dateformat = "%A, %B %e, %Y";
	$tr_ch_week1 = "Credits per week";
	$dec_point = '.';
	$thousands_sep = ',';
	$det_wcg_pr = 'Details';
	$det_wcg_pr_lnk = 'more Details';
	$tr_tb_01 = "-1h";
	$tr_tb_02 = "-2h";
	$tr_tb_06 = "-6h";
	$tr_tb_12 = "-12h";
	$tr_tb_to = "today";
	$tr_tb_ye = "yesterday";
	$tr_tb_pe = "Pendings";
	$tr_tb_det = "Details";
	$tr_th2_rp = "Retired Projects";
	$tr_ch_pie_01 = "BOINC Project Comparison";
	$tr_ch_pie_zwp = "Other";
	$tr_ch_pie_ret = "Finished projects";
	$tr_ch_go_header = "BOINC Total Credits";
	$tr_ch_go_yaxis = "Total Credits";
	$tr_ch_pc = "Pending Credits";
	$tr_ch_gh_header = "BOINC Total Credits per hours";
	$tr_ch_yaxis_hour = "Credits per hour";
	$tr_ch_gd_header = "BOINC Total Credits per day";
	$tr_ch_yaxis_day = "Credits per Day";
	$tr_ch_gw_header = "BOINC Total Credits per week";
	$tr_ch_yaxis_week = "Credits per week";
	$tr_ch_gm_header = "BOINC Total Credits per month";
	$tr_ch_yaxis_month = "Credits per month";
	$tr_ch_gy_header = "BOINC Total Credits per year";
	$tr_ch_yaxis_year = "Credits per year";
	$tr_ch_rp = "Position User in Project";
	$tr_ch_rt = "Position User in Team";
	$tr_ch_rw = "Position BOINC worldwide";
	$tr_ch_ra = "Position average worldwide";
	$tr_td_home = "Home";
	$tr_ch_pg_header = "Project-Total-Credits";
	$tr_ch_ps_header = "Project Credits per hour";
	$tr_ch_pd_header = "Project Credits per day";
	$tr_ch_pw_header = "Project Credits per week";
	$tr_ch_pm_header = "Project Credits per month";
	$tr_ch_py_header = "Project Credits per year";
	$tr_hp_pendings_01 = "The Pending-Credits of all your projects marked active will be refreshed....<br>Please wait....";
	$tr_hp_pendings_02 = "Your Pending-Credits were updated in the database.<br>Click <a href='index.php'>here</a>, to return to your personal stats";
	$tr_hp_pendings_03 = "Refresh your Pending Credits";
	$tr2_hp_pp = "# Project";
	$tr2_hp_pt = "# Team";
	$tr2_hp_ptotal = "# Total";
	$tr2_hp_pteam = "# Total/AVG";
	$tr2_hp_ms = "Member since";
	$tr2_hp_avg = "Average";
	$tr2_hp_tm = "Teammembers";
	$tr2_hp_country = "Country";
	$tr2_hp_comp = "Computer";
	$tr2_hp_total = "total";
	$tr2_hp_active = "active";
	$tr2_hp_mi = "more Information";
	$tr2_hp_privcomp = "no public host information";
	$td_hp_retired_info = "---------Project retired---------";
	
	$wcg_detail_team_history = "Team (History)";
	$wcg_detail_team = "Team Name";
	$wcg_detail_join = "Join";
	$wcg_detail_leave = "Leave";
	$wcg_detail_runtime = "Runtime";
	$wcg_detail_points = "Points";
	$wcg_detail_results = "Results";
	$wcg_detail_total = "Total";
	$wcg_detail_position = "Position";
	$wcg_detail_stats_per_project = "Statistics per Project";
	$wcg_detail_project = "Project";
	$wcg_detail_runtimedetail = "Runtime (y:d:h:m:s)";
	$wcg_detail_badge = "Badge";
	$wcg_detail_status = "Status";
	$wcg_detail_fehler = "ALERT";
	$wcg_detail_dbstatus = "Database ERROR";
	$wcg_detail_dbfehler_text01 = "No values returned from database.</br>There are some problems with your database connection.";
	$wcg_detail_dbfehler_text02 = "No values returned from database.";
	$wcg_detail_fehler_text01 = "Project status could not be initialized!<br>The servers may be down.";
	$wcg_detail_fehler_text02 = "Project status could not be initialized!<br>The values were not valid.";

	$project_of = "of";
	$project_project = "Project";
	$project_wcg_detail_link = "WCG-Detail-Statistics";
	$no_badge = "<h5><br>No badge configured</h5><h6><font size ='1'>To show your Boinc-Badges, please configure your Badges in the settings file.</font><br></h5>";

	$bt_headline = "Running WU's";

	$tabs_project = "Project";
	$tabs_pie = "Pie";
	$tabs_total = "Total";
	$tabs_hour = "Hour";
	$tabs_day = "Day";
	$tabs_week = "Week";
	$tabs_month = "Month";
	$tabs_year = "Year";
	$tabs_badge = "Badges";
	
	$tr_hp_header ='<!doctype html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="icon" type="image/png" href="favicon.gif">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
		<title>BOINC-Userstats</title>
	
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
		<meta name="viewport" content="width=device-width" />
	
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">

		<!-- Layout CSS -->
		<link href="./paper-kit/ct-paper.css" rel="stylesheet"/>
		<link href="./paper-kit/demo.css" rel="stylesheet"/>
		<link href="./paper-kit/examples.css" rel="stylesheet" /> 
	
		<!--     Fonts and icons     -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="https://cdn.datatables.net/plug-ins/1.10.16/integration/font-awesome/dataTables.fontAwesome.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
	
		<!-- JS JQuery und Bootstrap --> 
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
		<!--  Plugins -->
		<script src="./paper-kit/ct-paper-checkbox.js"></script>
		<script src="./paper-kit/ct-paper-radio.js"></script>
		<script src="./paper-kit/bootstrap-select.js"></script>
		<script src="./paper-kit/bootstrap-datepicker.js"></script>
		<script src="./paper-kit/ct-paper.js"></script>
	
		<script src="https://code.highcharts.com/stock/highstock.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
	
		<style type="text/css">
			.tab-content > .tab-pane:not(.active),
			.pill-content > .pill-pane:not(.active) {
				display: block;
				height: 0;
				overflow-y: hidden;
			}   
		</style>';
	
	// Hier die TOP-Navbar konfigurieren //
	$tr_hp_nav = '<nav class="navbar navbar-default" role="navigation-demo" id="demo-navbar">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="' .$hp_nav_brand_link. '">
					<div class="logo-container">
						<div class="logo">
							<img src="' .$brand_logo. '" alt="My Logo">
						</div>
						<div class="brand">
							' . $hp_username . '
						</div>
					</div>
				</a>
			</div>
			<div class="collapse navbar-collapse" id="navigation-example-2">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="' . $hp_nav_link01 . '" class="btn btn-neutral">' . $hp_nav_name01 . '</a>
					</li>
					<li>
						<a href="' . $hp_nav_link02 . '" class="btn btn-neutral">' . $hp_nav_name02 . '</a>
					</li>
					<li>
						<a href="' . $hp_nav_link03 . '" class="btn btn-neutral">' . $hp_nav_name03 . '</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>';
	
	$tr_hp_footer ='<!--footer ausgeben-->
	<footer class="footer-demo section-dark">
		<div class="container">
			<nav>
				<div class="copyright pull-center text-center">
					<a href="https://userstats.timo-schneider.de" target="_blank">BOINC Userstats</a> ' .$userstats_version. ', <i class="fa fa-copyright fa-lg"></i> 2017 by Timo Schneider (XSmeagolX)<br />Template by <a href="https://www.creative-tim.com/product/paper-kit">Creative Tim</a> - Diese Seite verwendet <a href="https://www.highcharts.com">Highcharts<i class="fa fa-copyright"></i></a>
					<br>
					<a class="btn btn-simple btn-sm" data-toggle="modal" data-target="#modalImpressum">Impressum</a> 
					<a class="btn btn-simple btn-sm" data-toggle="modal" data-target="#modalDisclaimer">Disclaimer</a> 
					<a class="btn btn-simple btn-sm" data-toggle="modal" data-target="#modalDatenschutz">Datenschutz</a> 
					<a href="https://github.com/XSmeagolX/Pers-nliche-BOINC-Userstats/blob/master/LICENSE" class="btn btn-simple btn-sm" target="_new">MIT License</a> 
				</div>
			</nav>
		</div>
	</footer>
	<!-- Modal -->
	<div class="modal fade" id="modalImpressum" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content ">
				<div class="modal-header section-light-blue">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="modelTitleId">Impressum</h4>
				</div>
				<div class="modal-body section-light-blue">
					Angaben gemäß § 5 TMG:<br>
					<br>
					<u>Kontakt:</u><br>
					' . $hp_username . '<br>
					<strong>E-Mail:</strong> ' . $hp_email . '
				</div>
				<div class="modal-footer section-light-blue">
					<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>  
	
	<div class="modal fade" id="modalDisclaimer" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header section-light-blue">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="modelTitleId">Haftungsausschluss (Disclaimer)</h4>
				</div>
				<div class="modal-body section-light-blue">
					<strong>Haftung für Inhalte</strong>
					<br>
					Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.
					<br>
					<br>
					<strong>Haftung für Links</strong>
					<br>
					Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.
					<br>
					<br>
					<strong>Urheberrecht</strong>
					<br>
					Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet. Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.
				</div>
				<div class="modal-footer section-light-blue">
					<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div> 
	
	<div class="modal fade" id="modalDatenschutz" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header section-light-blue">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="modelTitleId">Datenschutz</h4>
				</div>
				<div class="modal-body section-light-blue">
					<strong>Auskunft, Löschung, Sperrung</strong>
					<br>
					Sie haben jederzeit das Recht auf unentgeltliche Auskunft über Ihre gespeicherten personenbezogenen Daten, deren Herkunft und Empfänger und den Zweck der Datenverarbeitung sowie ein Recht auf Berichtigung, Sperrung oder Löschung dieser Daten. Hierzu sowie zu weiteren Fragen zum Thema personenbezogene Daten können Sie sich jederzeit unter der im Impressum angegebenen Adresse an uns wenden.
					<br>
					<br>
					<strong>Cookies</strong>
					<br>
					Die Internetseiten verwenden teilweise so genannte Cookies. Cookies richten auf Ihrem Rechner keinen Schaden an und enthalten keine Viren. Cookies dienen dazu, unser Angebot nutzerfreundlicher, effektiver und sicherer zu machen. Cookies sind kleine Textdateien, die auf Ihrem Rechner abgelegt werden und die Ihr Browser speichert.
					<br>
					Die meisten der von uns verwendeten Cookies sind so genannte „Session-Cookies“. Sie werden nach Ende Ihres Besuchs automatisch gelöscht. Andere Cookies bleiben auf Ihrem Endgerät gespeichert, bis Sie diese löschen. Diese Cookies ermöglichen es uns, Ihren Browser beim nächsten Besuch wiederzuerkennen.
					<br>
					Sie können Ihren Browser so einstellen, dass Sie über das Setzen von Cookies informiert werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies für bestimmte Fälle oder generell ausschließen sowie das automatische Löschen der Cookies beim Schließen des Browser aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalität dieser Website eingeschränkt sein.
					<br>
					<br>
					<strong>Server-Log-Files</strong>
					<br>
					Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten Server-Log Files, die Ihr Browser automatisch an uns übermittelt. Dies sind:
					<br>
					Browsertyp/ Browserversion
					verwendetes Betriebssystem
					Referrer URL
					Hostname des zugreifenden Rechners
					Uhrzeit der Serveranfrage
					<br>
					<br>
					Diese Daten sind nicht bestimmten Personen zuordenbar. Eine Zusammenführung dieser Daten mit anderen Datenquellen wird nicht vorgenommen. Wir behalten uns vor, diese Daten nachträglich zu prüfen, wenn uns konkrete Anhaltspunkte für eine rechtswidrige Nutzung bekannt werden.
					<br>
					<br>
					<strong>Kontaktformular</strong>
					<br>
					Wenn Sie uns per Kontaktformular Anfragen zukommen lassen, werden Ihre Angaben aus dem Anfrageformular inklusive der von Ihnen dort angegebenen Kontaktdaten zwecks Bearbeitung der Anfrage und für den Fall von Anschlussfragen bei uns gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.   
				</div>
				<div class="modal-footer section-light-blue">
					<button type="button" class="btn btn-default btn-simple" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>';        
?>
