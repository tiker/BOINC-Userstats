<?php
	//-----------------------------------------------------------------------------------
	// In dem folgenden Block bitte die Variablen mit Werten entsprechend der Anmerkung vornehmen
	//-----------------------------------------------------------------------------------
	
	# Anzeigen von Fehlermeldungen)
	error_reporting(E_ALL);
	#ini_set ('display_errors', 'On'); // für Testumgebung - for test environment
	ini_set ('display_errors', 'Off');

	//Version einbinden
	include "version.php";

	//Pfad zur Datenbank-Verbindung
	include "./db/boinc_db.php";
	
	// Main-Data für Navigation und Impressum //
	$hp_username = "Dein Name";
	$hp_email = "deine@email.adresse";
	
	//Navbar
	$showNavbar = false; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist false

	// für die Navbar sind drei Links vorgesehen
	// Bitte das Logo images/brand.jpg durch ein eigenes ersetzen
	$brand_logo = "../images/brand.jpg"; //das kleine Logo oben links neben dem Namen in der Navbar
	$hp_nav_name01 = "Link-Name#1";
	$hp_nav_link01 = "http://link.zu.Link-Name#1";
	$hp_nav_name02 = "Link-Name#2";
	$hp_nav_link02 = "http://link.zu.Link-Name#2";
	$hp_nav_name03 = "Link-Name#3";
	$hp_nav_link03 = "http://link.zu.Link-Name#3";
	
	//Header Hintergrund
	$header_backround_url = "./grafiken/header_background.jpg";   //Hier den Link zu deiner Header-Hintergrundgrafik einfuegen
	
	// User BOINC-Badges
	// Die Badge-Grafik kann man auch per cronjob 1x täglich in sein Webverzeichnis kopieren und dann hier relativ verlinken.
	// Dafür ist die Einrichtung der Badges über die Registrierung auf der Homepage von http://signature.statseb.fr notwendig.
	$showUserBadges = false; // true - wenn angezeigt werden soll, ansonsten auf false setzen. Standard ist false
	$linkUserBadges = "http://signature.statseb.fr/sig-12.png";   //Hier den Link zu Deinem User-Badge von http://signature.statseb.fr einfuegen
	
	// WCG-Badge-Signatur
	// Die WCG-Signatur kann man auch per cronjob 1x täglich in sein Webverzeichnis kopieren und dann hier relativ verlinken.
	// Dafür ist die Einrichtung der WCG-Signatur auf der Homepage von wcgsig.com notwendig (oben in der Mitte - Request a signature).
	$showWcgLogo = false; // true - wenn angezeigt werden soll, ansonsten auf false setzen. Standard ist false
	$linkWcgSig = "http://wcgsig.com/653215.gif";  //Hier den Link zu deinem WCG-Logo von http://wcgsig.com einfuegen
	
	// SG-WCG-Badges
	// Die Badge-Grafik kann man auch per cronjob 1x täglich in sein Webverzeichnis kopieren und dann hier relativ verlinken.
	// Hier kannst du die WCG-Badges des Badge-Generators von SETI.Germany integrieren. 
	// Hinter badge_ folgt dein WCG-Name, danach _ gefolgt von der Anzahl an Reihen. 0 steht für alle Badges in einer Reihe (halte ich am sinnvollsten)
	$showSgWcgBadges = false; // true - wenn angezeigt werden soll, ansonsten auf false setzen. Standard ist false
	$linkSgWcgBadges = "https://www.seti-germany.de/wcg/badge_XSmeagolX_0.png";  // WCG-Badges von XSmeagolX, alle in einer Reihe
	
	//Hier dein Teamname und die URL zu der Homepage deines Teams eintragen
	$hasTeamHp = true; 	// true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist false
	$teamHpName = "SETI.Germany";
	$teamHpURL = "https://www.seti-germany.de";
	
	//Hier die URL zu deinen Statistiken bei boincstats.com
	$hasBoincstats = false; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist false
	$linkNameBoincstats = "BOINCStats";
	$linkBoincstats = "https://boincstats.com/de/stats/-5/user/detail/865/projectList"; //Link zu boincstats.com von XSmeagolX
	
	//Hier die URL zu den laufenden WUs, falls Du diese mit Boinctasks veröffentlichst
	$hasBoinctasks = false; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist false
	$linkNameBoinctasks = "laufende WUs";
	$linkBoinctasks = "./tasks/tasks.html"; // Link zu den laufenden WUs von XSmeagolX
	
	//Hier die URL zum WCG, wird im Seitenkopf angezeigt
	$hasWcg = true; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist true
	$linkNameWcg = "World Community Grid";
	$linkWcg = "https://join.worldcommunitygrid.org/?recruiterId=653215&teamId=4VVG5BDPP1";

	//Option zum Anzeigen eines Links zum Aktualisieren der Pending Credits
	$hasPendings = false; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist false
	$linkNamePendings = "Pendings aktualisieren";
	$linkPendings = "./pendings.php"; // Link zu den laufenden WUs von XSmeagolX	

	//Hier die Zeitzoneneinstellung vornehmen (in Stunden)
	$timezoneoffset = 0;
	
	#Auswahl der Projekte fuer Tortendiagramm
	# Hier den Wert eintragen, ab welchem Prozentanteil die Projekte separat im Kuchen ausgegeben werden sollen (Standard 1 fuer ab 1%, kann aber auch 10, 2, 0.3 eingetragen werden)
	# 1 für Projekte ab 1% Gesamtanteil
	# 0 für alle Projekte
	$separat = 0.9;

?>
