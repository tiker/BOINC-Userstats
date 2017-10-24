<?php
	// Deutsche Version //
	$search= "Suche";
	$tr_hp_title = "<title>Persönliche Userstatistiken von " .$project_username. " aus dem Team " .$project_teamname. "</title>";
	$tr_th_bp = "BOINC-Projekte von";
	$tr_th_ot = "aus dem Team";
	$tr_th_lu = "letzte Aktualisierung";
	$tr_th_boinc_total = "BOINC Gesamt";
	$tr_th_total = "Gesamt";
	$tr_tb_pr = "aktive Projekte";
	$tr_tb_cr = "Credits";
	$tr_ch_week = "Woche ab";
	$tr_ch_dateformat = "%A, %e. %B %Y";
	$tr_ch_week1 = "Credits pro Woche";
	$dec_point = ',';
	$thousands_sep = '.' ;
	$det_wcg_pr = 'Details';
	$det_wcg_pr_lnk = 'mehr Details';
	$tr_tb_01 = "-1h";
	$tr_tb_02 = "-2h";
	$tr_tb_06 = "-6h";
	$tr_tb_12 = "-12h";
	$tr_tb_to = "heute";
	$tr_tb_ye = "gestern";
	$tr_tb_pe = "Pendings";
	$tr_tb_det = "Detail";
	$tr_th2_rp = "beendete Projekte";
	$tr_ch_pie_01 = "BOINC Projekt-Verteilung";
	$tr_ch_pie_zwp = "Zusammenfassung weiterer Projekte";
	$tr_ch_pie_ret = "Beendete Projekte";
	$tr_ch_go_header = "BOINC Gesamt-Credits";
	$tr_ch_go_yaxis = "Credits insgesamt";
	$tr_ch_pc = "ausstehende Credits";
	$tr_ch_gh_header = "BOINC Gesamt-Credits pro Stunde";
	$tr_ch_yaxis_hour = "Credits pro Stunde";
	$tr_ch_gd_header = "BOINC Gesamt-Credits pro Tag";
	$tr_ch_yaxis_day = "Credits pro Tag";
	$tr_ch_gw_header = "BOINC Gesamt-Credits pro Woche";
	$tr_ch_yaxis_week = "Credits pro Woche";
	$tr_ch_gm_header = "BOINC Gesamt-Credits pro Monat";
	$tr_ch_yaxis_month = "Credits pro Monat";
	$tr_ch_gy_header = "BOINC Gesamt-Credits pro Jahr";
	$tr_ch_yaxis_year = "Credits pro Jahr";
	$tr_ch_rp = "Position im Projekt";
	$tr_ch_rt = "Position im Team";
	$tr_ch_rw = "Position BOINC weltweit";
	$tr_ch_ra = "Position Durchschnitt weltweit";
	$tr_td_home	= "Home";
	$tr_ch_pg_header = "Projekt Credits - Gesamt";
	$tr_ch_ps_header = "Projekt Credits - Stunden";
	$tr_ch_pd_header = "Projekt Credits - Tag";
	$tr_ch_pw_header = "Projekt Credits - Woche";
	$tr_ch_pm_header = "Projekt Credits - Monat";
	$tr_ch_py_header = "Projekt Credits - Jahr";
	$tr_hp_pendings_01 = "Die Pending-Credits deiner als aktiv definierten Projekte werden aktualisiert....<br>Bitte warten....";
	$tr_hp_pendings_02 = "Die Pending-Credits deiner als aktiv markierten Projekte wurden in der Datenbank aktualisiert.<br>Klicke <a href='index.php'>hier</a>, um zu deiner Statistik-Uebersicht zurückzukehren";
	$tr_hp_pendings_03 = "Aktualisierung der Pending Credits";
	$tr2_hp_pp = "# Projekt";
	$tr2_hp_pt = "# Team";
	$tr2_hp_ptotal = "# Total";
	$tr2_hp_pteam = "# AVG";
	$tr2_hp_ms = "Mitglied seit";
	$tr2_hp_avg = "Durchschnitt";
	$tr2_hp_tm = "Teammitglieder";
	$tr2_hp_country = "Land";
	$tr2_hp_comp = "Computer";
	$tr2_hp_total = "gesamt";
	$tr2_hp_active = "aktiv";
	$tr2_hp_mi = "weitere Informationen";
	$tr2_hp_privcomp = "keine Host Infos veröffentlicht";
	$td_hp_retired_info = "---------Projekt beendet---------";
	
	$wcg_detail_team_history = "Team (Historie)";
	$wcg_detail_team = "Team Name";
	$wcg_detail_join = "Beitritt";
	$wcg_detail_leave = "Austritt";
	$wcg_detail_runtime = "Laufzeit";
	$wcg_detail_points = "Punkte";
	$wcg_detail_results = "Ergebnisse";
	$wcg_detail_total = "Gesamt";
	$wcg_detail_position = "Position";
	$wcg_detail_stats_per_project = "Statistiken nach Projekt";
	$wcg_detail_project = "Projekt";
	$wcg_detail_runtimedetail = "Laufzeit (y:d:h:m:s)";
	$wcg_detail_badge = "Badge";
	
	$project_of = "von";
	$project_project = "Projekt";
	$project_wcg_detail_link = "WCG-Detail-Statistik";
	$no_badge = "<h5>Keine BOINC-Badges eingerichtet</h5><h6><font size ='1'>Damit deine Boinc-Badges angezeigt werden, musst Du diese einrichten</font></h6>";
	$no_wcg_badge = "<h5>Keine WCG-Badge Signatur eingerichtet<h5><h6><font size ='1'>Damit deine WCG-Badge-Signatur angezeigt wird, musst Du diese einrichten</font></h6>";
	$no_sg_wcg_badge = "<h5>Keine SG-WCG-Badges eingerichtet</h5><h6><font size ='1'>Damit deine SG-WCG-Badges angezeigt werden, musst Du diese einrichten</h6></font>";

	$tabs_project = "Projekt";
	$tabs_pie = "Verteilung";
	$tabs_total = "Gesamt";
	$tabs_hour = "Stunde";
	$tabs_day = "Tag";
	$tabs_week = "Woche";
	$tabs_month = "Monat";
	$tabs_year = "Jahr";
	$tabs_badge = "Badges";
	
	$tr_hp_header ='<!doctype html>
	<html lang="de">
	<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="favicon.gif">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>BOINC-Userstats</title>
	
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="viewport" content="width=device-width" />
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"

	<!-- Layout CSS -->
	<link href="./paper-kit/ct-paper.css" rel="stylesheet"/>
	<link href="./paper-kit/demo.css" rel="stylesheet"/>
	<link href="./paper-kit/examples.css" rel="stylesheet" /> 
	<link href="./paper-kit/rotating-card.css" rel="stylesheet" />
	
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
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
	<span class="sr-only">Toggle navigation</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	</button>
	<a href="./index.php">
	<div class="logo-container">
	<div class="logo">
	<img src="' .$brand_logo. '" alt="My Logo">
	</div>
	<div class="brand">' . $hp_username . '</div>
	</div>
	</a>
	</div>
	<!-- Collect the nav links, forms, and other content for toggling -->
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
	</div><!-- /.navbar-collapse -->
	</div><!-- /.container-->
	</nav>';
	
	$tr_hp_footer ='<!--footer ausgeben-->
	<footer class="footer-demo section-dark">
	<div class="container">
	<nav>
	<ul>
	<li>
	<button class="btn btn-simple btn-sm" data-toggle="modal" data-target="#modalImpressum">Impressum</button> 
	</li>
	<li>
	<button class="btn btn-simple btn-sm" data-toggle="modal" data-target="#modalDisclaimer">Disclaimer</button> 
	</li>
	<li>
	<button class="btn btn-simple btn-sm" data-toggle="modal" data-target="#modalDatenschutz">Datenschutz</button> 
	</li>
	<li>
	<a href="https://github.com/XSmeagolX/Pers-nliche-BOINC-Userstats/blob/master/LICENSE" class="btn btn-simple btn-sm" target="_new">MIT License</a> 
	</li>
	<div class="copyright pull-right text-center"><a href="https://userstats.timo-schneider.de" target="_blank">BOINC Userstats</a> ' .$userstats_version. ', <i class="fa fa-copyright fa-lg"></i> 2017 by Timo Schneider (XSmeagolX)<br />Template by <a href="https://www.creative-tim.com/product/paper-kit">Creative Tim</a> - Diese Seite verwendet <a href="https://www.highcharts.com">Highcharts<i class="fa fa-copyright"></i></a></div>
	</ul>
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
	</div> ';        
?>
