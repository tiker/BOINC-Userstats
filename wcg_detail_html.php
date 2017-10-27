<?php
	include "./settings/settings.php";
	date_default_timezone_set('UTC');
	//-----------------------------------------------------------------------------------
	// ab hier bitte keine Aenderungen vornehmen, wenn man nicht weiß, was man tut!!! :D
	//-----------------------------------------------------------------------------------
	
	// Sprachdefinierung
	if(isset($_GET["lang"])) $lang=$_GET["lang"];
	else $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2));
	
	function zeit($sekunden)
	{
		$jahre = (int) ($sekunden / (365 * 86400));
		$sekunden %= (365 * 86400);
		$tage = (int) ($sekunden / (24 * 3600));
		$sekunden %= (24 * 3600);
		$stunden = (int) ($sekunden / 3600);
		$sekunden %= 3600;
		$minuten = (int) ($sekunden / 60);
		$sekunden %= 60;
		return array ($jahre, $tage, $stunden, $minuten, $sekunden);
	}
	############################################################
	# Beginn für Grundwerte einlesen
	$query_getUserData = mysqli_query($db_conn, "SELECT * FROM boinc_user");  //alle Userdaten einlesen
	if ( !$query_getUserData ) { 	
		$connErrorTitle = $wcg_detail_dbstatus;
		$connErrorDescription = $wcg_detail_dbfehler_text01;
		include "./errordocs/db_initial_err.php";
		exit();
	} elseif  ( mysqli_num_rows($query_getUserData) === 0 ) { 
		$connErrorTitle = $wcg_detail_dbstatus;
		$connErrorDescription = $wcg_detail_dbfehler_text02;
		include "./errordocs/db_initial_err.php";
		exit();
	}
	$project_wcgname = "";
	$wcg_verification = "";
	while ($row = mysqli_fetch_assoc($query_getUserData)) {
		$project_username = $row["boinc_name"];
		$project_wcgname = $row["wcg_name"];
		$wcg_verification = $row["wcg_verificationkey"];
		$project_teamname = $row["team_name"];
		$cpid = $row["cpid"];
		$datum_start = $row["lastupdate_start"];
		$datum = $row["lastupdate"];
	}
	########################################################
	# Abruf des Projekt-Status

	$xml_string = FALSE;
	$status = [];
	$xml_string = @file_get_contents ("https://www.worldcommunitygrid.org/stat/viewProjects.do?xml=true");
	$xml = @simplexml_load_string($xml_string);
	if ( $xml !== FALSE) {
		if ( $xml->getName() == 'unavailable') {
			echo "<div class='alert alert-danger text-center'><strong>" . $wcg_detail_fehler . "</strong> " . $wcg_detail_fehler_text01 . "</div>"; 
		}
	}		    
	 	else {
			echo "<div class='alert alert-danger text-center'><strong>" . $wcg_detail_fehler . "</strong> " . $wcg_detail_fehler_text02 . "</div>"; 
		}

	foreach ($xml->Project as $project_status)
	       {
	         $status[strval($project_status->Name)] = strval($project_status->Status);
	         }
	
	$xml_string = FALSE;
	$xml_string = @file_get_contents ("http://www.worldcommunitygrid.org/verifyMember.do?name=" . $project_wcgname . "&code=" . $wcg_verification . "");
	$xml = @simplexml_load_string($xml_string);
	if($xml_string == FALSE)  echo "<div class='alert alert-danger'>
										<strong>FEHLER!</strong> Die Liste der Projekte ist derzeit nicht verfügbar!
									  </div>";
	$last_result = strval($xml->MemberStats->MemberStat->LastResult);
	
	############################################################	
	# Total Stats fuer wcg_total_werte
	$total_time_stamp = date('Y-m-d H'). ':00:00';
	$user_total_runtime_seconds = strval($xml->MemberStats->MemberStat->StatisticsTotals->RunTime);
	$a = zeit($user_total_runtime_seconds);
	$user_total_runtime = $a[0].':'.sprintf('%03d',$a[1]).':'.sprintf('%02d',$a[2]).':'.sprintf('%02d',$a[3]).':'.sprintf('%02d',$a[4]);	
	$user_total_runtime_rank = strval($xml->MemberStats->MemberStat->StatisticsTotals->RunTimeRank);
	$user_total_points = strval($xml->MemberStats->MemberStat->StatisticsTotals->Points);
	$user_total_points_rank = strval($xml->MemberStats->MemberStat->StatisticsTotals->PointsRank);
	$user_total_results = strval($xml->MemberStats->MemberStat->StatisticsTotals->Results);
	$user_total_results_rank = strval($xml->MemberStats->MemberStat->StatisticsTotals->ResultsRank);
	
	############################################################
	# Team Stats fuer wcg_team (aktualisieren der Teams fuer wcg_team
	foreach ($xml->TeamHistory->Team as $team_history)
	{
		$table_row["team_name"] = strval($team_history->Name);
		$table_row["team_join_date"] = strval($team_history->JoinDate);
		$table_row["team_retire_date"] = strval($team_history->RetireDate);
		$team_total_runtime = strval($team_history->StatisticsTotals->RunTime);
		$trt=zeit($team_total_runtime);
		$table_row["team_runtime"] = $trt[0].':'.sprintf('%03d',$trt[1]).':'.sprintf('%02d',$trt[2]).':'.sprintf('%02d',$trt[3]).':'.sprintf('%02d',$trt[4]);	
		$table_row["team_points"] = strval($team_history->StatisticsTotals->Points);
		$table_row["team_results"] = strval($team_history->StatisticsTotals->Results);
		
		$table_team[]=$table_row;
	}
	
	
	############################################################	
	# Project Badges (aktualisieren der wcg-badges fuer wcg_badges)
	foreach ($xml->MemberStats->MemberStat->Badges->Badge as $project_badge)  
	{
		$table_row["project_fullname"] = strval($project_badge->ProjectName);
		$table_row["badge"] = strval($project_badge->Resource->Url);	
		$table_row["description"] = strval($project_badge->Resource->Description);	
		
		$badges[strval($project_badge->ProjectName)]=$table_row;
	}
	
	############################################################
	# Project Stats fuer wcg_project_werte
	$timestamp = date('Y-m-d H'). ':00:00';
	foreach ($xml->MemberStatsByProjects->Project as $project_values)  
	{
		$table_row["project_shortname"] = strval($project_values->ProjectShortName);
		
		$longname=strval($project_values->ProjectName);
		$table_row["project_longname"] = $longname;
		$project_runtime = strval($project_values->RunTime);
		$prt=zeit($project_runtime);
		$table_row["project_runtime_unix"] = $project_runtime;
		$table_row["project_runtime"] = $prt[0].':'.sprintf('%03d',$prt[1]).':'.sprintf('%02d',$prt[2]).':'.sprintf('%02d',$prt[3]).':'.sprintf('%02d',$prt[4]);		
		$table_row["project_points"] = strval($project_values->Points);
		$table_row["project_results"] = strval($project_values->Results);
		
		if(isset($badges[$longname])){
			$table_row["badge"] = $badges[$longname]["badge"];	
			$table_row["description"] = $badges[$longname]["description"];	
		}
		else{
			$table_row["badge"] = "";	
			$table_row["description"] = "&nbsp;";	
		}

		$table_row["status"] = $status[$longname];	
		
		$table[]=$table_row;
	}		

	if (file_exists("./lang/" .$lang. ".txt.php")) include "./lang/" .$lang. ".txt.php";
	else include "./lang/en.txt.php";
?>

<style>
	@media (min-width: 768px) {
	.modal-dialog {
	width: 750px;
	margin: 30px auto;
	}
	.modal-content {
	-webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
	box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
	6}
	.modal-sm {
	width: 300px;
	}
	}
	@media (min-width: 960px) {
	.modal-dialog {
	width: 900px;
	margin: 30px auto;
	}
	.modal-content {
	-webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
	box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
	6}
	.modal-sm {
	width: 300px;
	}
	}
	
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

<div class="container-fluid">
<b><?php echo "$wcg_detail_team_history" ?></b>
	<table class="table table-striped text-right table-condensed" width="100%" style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
		<thead>
			<tr class='alert alert-warning'>
				<th class='text-center'><b><?php echo "$wcg_detail_team" ?></b></th>
				<th class='hidden-xs text-center'><b><?php echo "$wcg_detail_join" ?></b></th>
				<th class='hidden-xs text-center'><b><?php echo "$wcg_detail_leave" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_runtime" ?></b></th>
				<th class='hidden-xs text-center'><b><?php echo "$wcg_detail_points" ?></b></th>
				<th class='hidden-xs text-center'><b><?php echo "$wcg_detail_results" ?></b></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($table_team as $table_row) {
					if ($table_row["team_retire_date"] > 0) { // Team Historie
						echo "<tr class='text-muted'>";
						echo "  <td align='right'>" .$table_row["team_name"]. "</td>";
						echo "  <td class='hidden-xs text-center'>" .$table_row["team_join_date"]. "</td>";
						echo "  <td class='hidden-xs text-center'>" .$table_row["team_retire_date"]. "</td>";
						echo "  <td align='right'>" .$table_row["team_runtime"]. "</td>";
						echo "  <td class='hidden-xs text-right'>" .number_format($table_row["team_points"],0,$dec_point,$thousands_sep). "</td>";
						echo "  <td class='hidden-xs text-right'>" .number_format($table_row["team_results"],0,$dec_point,$thousands_sep). "</td>";	
						echo "</tr>";
					} else { //* aktuelles Team
						echo "<tr class = 'text-success'>";
						echo "  <td align='right'>" .$table_row["team_name"]. "</td>";
						echo "  <td class='hidden-xs text-center'>" .$table_row["team_join_date"]. "</td>";
						echo "  <td class='hidden-xs text-center'>&nbsp;</td>";
						echo "  <td align='right'>" .$table_row["team_runtime"]. "</td>";
						echo "  <td class='hidden-xs text-right'>" .number_format($table_row["team_points"],0,$dec_point,$thousands_sep). "</td>";
						echo "  <td class='hidden-xs text-right'>" .number_format($table_row["team_results"],0,$dec_point,$thousands_sep). "</td>";	
						echo "</tr>";
					}					
				}
				
				echo "<tr class='alert-info text-info'>";
				echo "<td>Gesamt";
				echo "<br><font size ='2'>Position</font></td>";
				echo "  <td class='hidden-xs'><br></td>";
				echo "  <td class='hidden-xs'><br></td>";
				echo "  <td class='text-right'>" .$user_total_runtime. "<br><font size ='2'>(# " .number_format($user_total_runtime_rank,0,$dec_point,$thousands_sep). ")</font></td>";
				echo "  <td class='hidden-xs text-right'>" .number_format($user_total_points,0,$dec_point,$thousands_sep). "<br><font size ='2'>(# " .number_format($user_total_points_rank,0,$dec_point,$thousands_sep). ")</font></td>";
				echo "  <td class='hidden-xs text-right'>" .number_format($user_total_results,0,$dec_point,$thousands_sep). "<br><font size ='2'>(# " .number_format($user_total_results_rank,0,$dec_point,$thousands_sep). ")</font></td>";
				echo "</tr>";
				
			?>
		</tbody>
	</table>
	<br>
	<b><?php echo "$wcg_detail_stats_per_project" ?></b>
	<table id="table_wcg" class="table table-striped text-right table-condensed" style="width: 100%; background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
		<thead>
			<tr class='alert alert-warning'>
				<th class='text-center'><b><?php echo "$wcg_detail_project" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_status" ?></b></th>
				<th class='hidden-xs text-center'><b><?php echo "$wcg_detail_points" ?></b></th>
				<th class='hidden-xs text-center'><b><?php echo "$wcg_detail_results" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_runtimedetail" ?></b></th>
				<th class='text-center no-sort'><b><?php echo "$wcg_detail_badge" ?></b></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($table as $table_row){
					if ( isset($table_row["project_points"]) && $table_row["project_points"] > 0) {
						if ($table_row["status"] === "Active") {
								echo "<tr class = 'text-success'>";
								echo "<td>" .$table_row["project_longname"]. "</td>";
								echo "  <td data-order='1' align='center'><i class='fa fa-square' aria-hidden='true'></i></td>";	
								echo "  <td class='hidden-xs'>" .number_format($table_row["project_points"],0,$dec_point,$thousands_sep). "</td>";
								echo "  <td class='hidden-xs'>" .number_format($table_row["project_results"],0,$dec_point,$thousands_sep). "</td>";	
								echo "  <td data-order='" . $table_row["project_runtime_unix"] . "'>" .$table_row["project_runtime"]. "</td>";
								echo "  <td align='center'><img title='" .$table_row["description"]. "' src='" .$table_row["badge"]. "' alt='" .$table_row["description"]. "'></td>";						
								echo "</tr>";
						} elseif ($table_row["status"] === "Intermittent") {
								echo "<tr class = 'text-warning'>";
								echo "<td>" .$table_row["project_longname"]. "</td>";
								echo "  <td data-order='2' align='center'><i class='fa fa-square' aria-hidden='true'></i></td>";
								echo "  <td class='hidden-xs'>" .number_format($table_row["project_points"],0,$dec_point,$thousands_sep). "</td>";
								echo "  <td class='hidden-xs'>" .number_format($table_row["project_results"],0,$dec_point,$thousands_sep). "</td>";	
								echo "  <td data-order='" . $table_row["project_runtime_unix"] . "'>" .$table_row["project_runtime"]. "</td>";
								echo "  <td align='center'><img title='" .$table_row["description"]. "' src='" .$table_row["badge"]. "' alt='" .$table_row["description"]. "'></td>";
								echo "</tr>";
						} elseif ($table_row["status"] === "Completed") {
								echo "<tr class = 'text-danger'>";
								echo "<td>" .$table_row["project_longname"]. "</td>";
								echo "  <td data-order='3' align='center'><i class='fa fa-square' aria-hidden='true'></i></td>";
								echo "  <td class='hidden-xs'>" .number_format($table_row["project_points"],0,$dec_point,$thousands_sep). "</td>";
								echo "  <td class='hidden-xs'>" .number_format($table_row["project_results"],0,$dec_point,$thousands_sep). "</td>";	
								echo "  <td data-order='" . $table_row["project_runtime_unix"] . "'>" .$table_row["project_runtime"]. "</td>";
								echo "  <td align='center'><img title='" .$table_row["description"]. "' src='" .$table_row["badge"]. "' alt='" .$table_row["description"]. "'></td>";
								echo "</tr>";
						} else {
								echo "<tr class = 'text-primary'>";
								echo "<td>" .$table_row["project_longname"]. "</td>";
								echo "  <td data-order='3' align='center'> - </td>";
								echo "  <td class='hidden-xs'>" .number_format($table_row["project_points"],0,$dec_point,$thousands_sep). "</td>";
								echo "  <td class='hidden-xs'>" .number_format($table_row["project_results"],0,$dec_point,$thousands_sep). "</td>";	
								echo "  <td data-order='" . $table_row["project_runtime_unix"] . "'>" .$table_row["project_runtime"]. "</td>";
								echo "  <td align='center'><img title='" .$table_row["description"]. "' src='" .$table_row["badge"]. "' alt='" .$table_row["description"]. "'></td>";
								echo "</tr>";
						}		
					}
				}
			?>
		</tbody>
	</table>
</div>

<script>
	$(document).ready(function() {
		$('#table_wcg').DataTable( {
			"language": {
            	"decimal": "<?php echo $dec_point; ?>",
            	"thousands": "<?php echo $thousands_sep; ?>",
				"search":	"<?php echo $search; ?>"
        	},
			"order": [[ 1, "asc" ],[ 0, "asc" ]],
    		"columnDefs": [ {
      			"targets"  : 'no-sort',
      			"orderable": false,
    		}],
			"paging":   false,
			"info":     false
		} );
	} );
</script>
