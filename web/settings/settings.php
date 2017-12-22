<?php
	// -----------------------------------------------------------------------------------
	// In dem folgenden Block bitte die Variablen mit Werten 
	// entsprechend der Anmerkung vornehmen
	// -----------------------------------------------------------------------------------
	
	// Anzeigen von Fehlermeldungen
	error_reporting(E_ALL);
	// ini_set ('display_errors', 'On'); // für Testumgebung - for test environment
	ini_set ('display_errors', 'Off');

	// Zeitzonen Einstellungen  // Timezone Settings
	// Deine Zeitzone  // Enter your timezone
	date_default_timezone_set('Europe/Berlin');

	// Deine Zeitzonenbezeichnung in Kurzform. Wird in der Infobar neben den Zeitangabe für das letzte Update angezeigt. Derzeit noch keine Unterstützung für Sommerzeitregelung.	
	// Your Timezone Shortname. Will be shown in the Infobar next to the last update dates. No support for Daylight Savings at the moment.
	$timezone_shortname = "(MEZ)"; 

	// Diese Variable bitte nicht ändern, ansosten werden deine Werte falsch berechnet!
	// Do not change the this option, otherwise your data will be calculated wrong!
	$useUTCHighchartsOption = "true"; // default = "true"

	// Wenn dein Webserver die Zeit in der deiner Zeitzone anzeigt, so lasse hier die "0" stehen
	// ansonsten musst Du hier die Differenz deiner Zeitzone zur Zeitzone des Webservers eintragen
	// If timezone of your webserver is equal to your timezone, keep the value "0"
	// otherwise set this value to the difference of your webserver timezone to your timezone
	$timezoneoffset = 0; // in Minuten //in minutes

	// Version einbinden   // Include version
	include "version.php";

	// Pfad zur Datenbank-Verbindung     // Path to database connect
	include "/absolute/path/to/boinc_db_connect.php";
	
	// Daten für Impressum //
	$hp_username = "Dein Name";
	$hp_email = "deine@email.adresse";
	
	// Navbar - DAS DEAKTIVIEREN FÜHRT ZU FEHLERHAFTER DESIGN-DARSTELLUNG
	$showNavbar = true; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist true

	// für die Navbar sind verschiedene Links möglich
	$brand_logo = "./assets/images/brand_logo.png"; //das kleine Logo oben links neben dem Namen in der Navbar
	$hp_nav_brand_link = "./index.php"; //wohin der Link auf dem Brand-Logo führen soll

	// individuelle Links
	$showLinks = false; // true - wenn die folgenden Links in der Navbar angezeigt werden sollen
	$hp_nav_name01 = "Link-Name#1";
	$hp_nav_link01 = "http://link.zu.Link-Name#1";
	$hp_nav_name02 = "Link-Name#2";
	$hp_nav_link02 = "http://link.zu.Link-Name#2";
	$hp_nav_name03 = "Link-Name#3";
	$hp_nav_link03 = "http://link.zu.Link-Name#3";
	
	$showMoreLinks = true; // true - wenn Links zu Seiten des Programmierers (XSmeagolX) angezeigt werden sollen
	$showMoreLinksName = "weitere Links";

	// Header Hintergrund
	$header_backround_url = "./assets/images/header_background.jpg"; //Hier den Link zu deiner Header-Hintergrundgrafik einfuegen
	
	// User BOINC-Badges
	// Die Badge-Grafik kann man auch per cronjob 1x täglich in sein Webverzeichnis kopieren und dann hier relativ verlinken.
	// Dafür ist die Einrichtung der Badges über die Registrierung auf der Homepage von http://signature.statseb.fr notwendig.
	$showUserBadges = true; // true - wenn angezeigt werden soll, ansonsten auf false setzen. Standard ist false
	$linkUserBadges = "https://signature.statseb.fr/sig-12.png"; //Hier den Link zu Deinem User-Badge von http://signature.statseb.fr einfuegen
	
	// WCG-Badge-Signatur
	// Die WCG-Signatur kann man auch per cronjob 1x täglich in sein Webverzeichnis kopieren und dann hier relativ verlinken.
	// Dafür ist die Einrichtung der WCG-Signatur auf der Homepage von wcgsig.com notwendig (oben in der Mitte - Request a signature).
	$showWcgLogo = true; // true - wenn angezeigt werden soll, ansonsten auf false setzen. Standard ist false
	$linkWcgSig = "http://wcgsig.com/653215.gif"; //Hier den Link zu deinem WCG-Logo von http://wcgsig.com einfuegen
	
	// SG-WCG-Badges
	// Die Badge-Grafik kann man auch per cronjob 1x täglich in sein Webverzeichnis kopieren und dann hier relativ verlinken.
	// Hier kannst du die WCG-Badges des Badge-Generators von SETI.Germany integrieren. 
	// Hinter badge_ folgt dein WCG-Name, danach _ gefolgt von der Anzahl an Reihen. 0 steht für alle Badges in einer Reihe (halte ich am sinnvollsten)
	$showSgWcgBadges = true; // true - wenn angezeigt werden soll, ansonsten auf false setzen. Standard ist false
	$linkSgWcgBadges = "https://www.seti-germany.de/wcg/badge_XSmeagolX_0.png"; // WCG-Badges von XSmeagolX, alle in einer Reihe
	
	// Hier dein Teamname und die URL zu der Homepage deines Teams eintragen
	// Falls die Links zum Dev nicht angezeigt werden sollen, oder man ist Mitglied eines anderen Teams,
	// so kann hier individuell der Link zum BOINC-Team aktiviert werden
	$hasTeamHp = false; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist false
	$teamHpName = "SETI.Germany";
	$teamHpURL = "https://www.seti-germany.de";
	
	// Hier die URL zu deinen Statistiken bei boincstats.com
	$hasBoincstats = true; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist false
	$linkNameBoincstats = "BOINCStats";
	$linkBoincstats = "https://boincstats.com/de/stats/-5/user/detail/15232873522/projectList"; //Link zu boincstats.com von XSmeagolX
	
	// Hier die URL zu SG-Stats von XSmeagolX aktivieren
	$hasSGStats = true; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist true
	$linkNameSGStats = "SG-Stats";
	$linkSGStats = "https://timo-schneider.de/sgstats/"; //Link zu den SG-Stats von XSmeagolX

	// Hier die URL zu den laufenden WUs, falls Du diese mit Boinctasks veröffentlichst
	$hasBoinctasks = true; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist false
	$linkNameBoinctasks = "Tasks";
	$linkBoinctasks = "./tasks.php"; // Link zu den laufenden WUs von XSmeagolX
	$linkUploadFileBoinctasks = "./tasks/tasks.html"; // Link zum Upload-File von Boinctasks

	// Hier die URL zum WCG, wird im Seitenkopf angezeigt
	// Falls die Links zum Dev nicht angezeigt werden sollen, so kann hier individuell der Link zum WCG aktiviert werden
	$hasWcg = false; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist true
	$linkNameWcg = "WCG";
	$linkWcg = "https://join.worldcommunitygrid.org/?recruiterId=653215&teamId=4VVG5BDPP1";

	// Option zum Anzeigen eines Links zum Aktualisieren der Pending Credits
	$hasPendings = true; // true - wenn angezeigt werden soll, ansonten auf false setzen. Standard ist false
	$linkNamePendings = "Pendings";
	$linkPendings = "./pendings.php"; // Link zu den laufenden WUs von XSmeagolX	
	
	// Auswahl der Projekte fuer Tortendiagramm
	// Hier den Wert eintragen, ab welchem Prozentanteil die Projekte separat im Kuchen ausgegeben werden sollen (Standard 1 fuer ab 1%, kann aber auch 10, 2, 0.3 eingetragen werden)
	// 1 für Projekte ab 1% Gesamtanteil
	// 0 für alle Projekte
	$separat = 0.9;

?>
