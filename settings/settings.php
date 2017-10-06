<?php
	//-----------------------------------------------------------------------------------
	// In dem folgenden Block bitte die Variablen mit Werten entsprechend der Anmerkung vornehmen
	//-----------------------------------------------------------------------------------
	
	# Um das Anzeigen von Fehlermeldungen zu aktivieren, bitte die nächste Zeile "deaktivieren" (Hinzufügen eines '#' am Anfang der Zeile)
	error_reporting(0); 
	
	//Pfad zur Datenbank-Verbindung
	include "/pfad/zur/boinc_db.php";
	
	// Main-Data für Navigation und Impressum //
	$hp_username = "Dein Name";
	$hp_email = "deine@email.adresse";
	
	//Navbar
	$navbar = false ; 
	// hier besser true/false und dann eigentlich besser $showNavbar
	//Hier 1 für Navbar oder 0 für keine Header-Navigation
	// für die Navbar sind drei Links vorgesehen
	// Bitte das Logo images/brand.jpg durch ein eigenes ersetzen
	// Please replace images/brand.jpg with your own logo
	$link_user_logo = "../images/brand.jpg";
	$hp_nav_name01 ="Link-Name#1";
	$hp_nav_link01 ="http://link.zu.Link-Name#1";
	$hp_nav_name02 ="Link-Name#2";
	$hp_nav_link02 ="http://link.zu.Link-Name#2";
	$hp_nav_name03 ="Link-Name#3";
	$hp_nav_link03 ="http://link.zu.Link-Name#3";
	
	//Header Hintergrund
	$header_backround_url = "./grafiken/header_background.jpg";   //Hier den Link zu deiner Headergrafik einfuegen
	
	//Userlogo
	$userlogo = false; // 1 - wenn angezeigt werden soll, ansonsten auf 0 setzen
	// hier besser true/false und dann eigentlich besser $showUserLogo
	// wo verwendet?
	
	// User BOINC-Badges
	// Die Badge-Grafik kann man auch per cronjob 1x täglich in sein Webverzeichnis kopieren und dann hier relativ verlinken.
	$userbadges = false; // 1 - wenn angezeigt werden soll, ansonsten auf 0 setzen
	// hier besser true/false und dann eigentlich besser $showUserBadges
	$link_user_badges = "http://signature.statseb.fr/sig-12.png";   //Hier den Link zu Deinem User-Badge von http://signature.statseb.fr einfuegen
	
	// WCG-Badge-Signatur
	// Die WCG-Signatur kann man auch per cronjob 1x täglich in sein Webverzeichnis kopieren und dann hier relativ verlinken.
	$wcglogo = false; // 1 - wenn angezeigt werden soll, ansonsten auf 0 setzen
	// hier besser true/false und dann eigentlich besser $showWcgLogo
	$link_wcg_sig = "http://wcgsig.com/653215.gif";  //Hier den Link zu deinem WCG-Logo von http://wcgsig.com einfuegen
	
	// SG-WCG-Badges
	// Die Badge-Grafik kann man auch per cronjob 1x täglich in sein Webverzeichnis kopieren und dann hier relativ verlinken.
	$sgwcgbadges = false; // 1 - wenn angezeigt werden soll, ansonsten auf 0 setzen
	// hier besser true/false und dann eigentlich besser $showSgWcgBadges
	// wo verwendet?
	$link_sg_wcg_badges = "https://www.seti-germany.de/wcg/badge_XSmeagolX_0.png";  //Hier kannst du die WCG-Badges des Badge-Generators von SETI.Germany integrieren. Hinter badge_ folgt dein WCG-Name, danach _ gefolgt von der Anzahl an Reihen. 0 steht für alle Badges in einer Reihe (halte ich am sinnvollsten)
	
	
	//Hier dein Teamname und die URL zu der Homepage deines Teams eintragen
	$has_team_hp = true;
	// hier besser true/false und dann eigentlich besser $hasTeamHp
	$link_name_teamname = "SETI.Germany";
	$team_hp = "https://www.seti-germany.de";
	
	//Hier die URL zu deinen Statistiken bei boincstats.com
	$has_boincstats = false;
	// hier besser true/false und dann eigentlich besser $hasBoinstats
	$link_name_boincstats = "BOINCStats";
	$boincstats_link = "https://boincstats.com/de/stats/-5/user/detail/865/projectList"; //Link zu boincstats.com von XSmeagolX
	
	//Hier die URL zu den laufenden WUs, falls Du diese mit Boinctasks veröffentlichst
	$has_boinctasks = false;
	// hier besser true/false und dann eigentlich besser $hasBoinstats
	$link_name_boinctasks = "laufende WUs";
	$boinctasks_link = "./tasks/tasks.html"; // Link zu den laufenden WUs von XSmeagolX
	
	//Hier die URL zum WCG, wird im Seitenkopf angezeigt
	$has_wcg = true;
	// hier besser true/false und dann eigentlich besser $hasWcg
	$link_name_wcg = "World Community Grid";
	$wcg_link = "https://join.worldcommunitygrid.org/?recruiterId=653215&teamId=4VVG5BDPP1";
	
	//Hier die Zeitzoneneinstellung vornehmen (in Stunden)
	$timezoneoffset = 0;
	
	#Auswahl der Projekte fuer Tortendiagramm
	# Hier den Wert eintragen, ab welchem Prozentanteil die Projekte seperat im Kuchen ausgegeben werden sollen (Standard 1 fuer ab 1%, kann aber auch 10, 2, 0.3 eingetragen werden)
	# 1 für Projekte ab 1% Gesamtanteil
	# 0 für alle Projekte
	$seperat = 0.9;
	
	//Versionsnummer
	$userstats_version = "V 4.2 alpha";
?>
