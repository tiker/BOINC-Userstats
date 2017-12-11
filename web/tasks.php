<?php
	include "./settings/settings.php";

	$showProjectHeader = false;
	$showPendingsHeader = false;
	$showTasksHeader = true;

	if (isset($_GET["lang"])) $lang = $_GET["lang"];
	else $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));

	if (file_exists("./lang/" . $lang . ".txt.php")) include "./lang/" . $lang . ".txt.php";
	else include "./lang/en.txt.php";

	$query_getUserData = mysqli_query($db_conn, "SELECT * from boinc_user");
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
	
	$lastupdate_start = date("d.m.Y H:i:s", $datum_start + $timezoneoffset*3600);
	$lastupdate = date("H:i:s", $datum + $timezoneoffset*3600);
?>

<?php
	include("./header.php"); 

	include ($linkUploadFileBoinctasks);
?>

		<script>
			$(document).ready(function() {
				$('#table_tasks').DataTable( {
					fixedHeader: {
						headerOffset: 56
					},
					language: {
						decimal: "<?php echo $dec_point; ?>",
						thousands: "<?php echo $thousands_sep; ?>",
						search:	"<?php echo $text_search; ?>"
					},
					columnDefs: [ {
						targets: 'no-sort',
						orderable: false,
					}],
					order: [[ 6, "asc" ],[ 0, "asc" ]],
					paging: false,
					info: false
				} );
			} );
		</script>

<?php include("./footer.php"); ?>
