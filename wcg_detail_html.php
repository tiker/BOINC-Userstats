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
	$result_user = mysqli_query($db_conn, "SELECT * FROM boinc_user");  //alle Userdaten einlesen
	$project_wcgname = null;
	$wcg_verification = null;
	while ($row = mysqli_fetch_assoc($result_user)) {
		$project_username = $row["boinc_name"];
		$project_wcgname = $row["wcg_name"];
		$wcg_verification = $row["wcg_verificationkey"];
		$project_teamname = $row["team_name"];
		$cpid = $row["cpid"];
		$datum_start = $row["lastupdate_start"];
		$datum = $row["lastupdate"];
	}
	$xml_string = @file_get_contents ("http://www.worldcommunitygrid.org/verifyMember.do?name=" . $project_wcgname . "&code=" . $wcg_verification . "");
	$xml = @simplexml_load_string($xml_string);
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
<div class="container-fluid">
	<table class="table table-striped text-right table-condensed" style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
		<thead>
			<tr>
				<th colspan = '6'><b><?php echo "$wcg_detail_team_history" ?></b></th>
			</tr>
			<tr class='alert alert-warning'>
				<th class='text-center'><b><?php echo "$wcg_detail_team" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_join" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_leave" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_runtime" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_points" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_results" ?></b></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($table_team as $table_row){
					echo "<tr>";
					echo "<td align='center'>" .$table_row["team_name"]. "";
					echo "</td>";
					echo "  <td align='center'>" .$table_row["team_join_date"]. "</td>";
					if ($table_row["team_retire_date"] > 0) {
						echo "  <td align='center'>" .$table_row["team_retire_date"]. "</td>";
					} else echo "<td align='center'>&nbsp;</td>";
					echo "  <td align='right'>" .$table_row["team_runtime"]. "</td>";
					echo "  <td align='right'>" .number_format($table_row["team_points"],0,$dec_point,$thousands_sep). "</td>";
					echo "  <td align='right'>" .number_format($table_row["team_results"],0,$dec_point,$thousands_sep). "</td>";	
					echo "</tr>";
				}
				
				echo "<tr class='alert alert-info'>";
				echo "<td>Gesamt";
				echo "<br>Position</td>";
				echo "  <td><br></td>";
				echo "  <td><br></td>";
				echo "  <td class='text-right'>" .$user_total_runtime. "<br>(# " .number_format($user_total_runtime_rank,0,$dec_point,$thousands_sep). ")</td>";
				echo "  <td class='text-right'>" .number_format($user_total_points,0,$dec_point,$thousands_sep). "<br>(# " .number_format($user_total_points_rank,0,$dec_point,$thousands_sep). ")</td>";
				echo "  <td class='text-right'>" .number_format($user_total_results,0,$dec_point,$thousands_sep). "<br>(# " .number_format($user_total_results_rank,0,$dec_point,$thousands_sep). ")</td>";	
				echo "</tr>";
				
			?>
		</tbody>
	</table>
	<br>
	<table class="table table-striped text-right table-condensed" style="background: linear-gradient(to bottom, #FFFFFF 70%, #F3F3F3 100%); box-shadow: 0 1px 2px rgba(0,0,0,0.4);">
		<thead>
			<tr>
				<th colspan = '5'><b><?php echo "$wcg_detail_stats_per_project" ?></b></th>
			</tr>
			<tr class='alert alert-warning'>
				<th class='text-center'><b><?php echo "$wcg_detail_project" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_points" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_results" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_runtimedetail" ?></b></th>
				<th class='text-center'><b><?php echo "$wcg_detail_badge" ?></b></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($table as $table_row){
					if ($table_row["project_points"] > 0) {
						echo "<tr>";
						echo "<td>" .$table_row["project_longname"]. "";
						echo "</td>";
						echo "  <td>" .number_format($table_row["project_points"],0,$dec_point,$thousands_sep). "</td>";
						echo "  <td>" .number_format($table_row["project_results"],0,$dec_point,$thousands_sep). "</td>";	
						echo "  <td>" .$table_row["project_runtime"]. "</td>";
						echo "  <td align='center'><img title='" .$table_row["description"]. "' src='" .$table_row["badge"]. "' alt='" .$table_row["description"]. "'></td>";
						echo "</tr>";
					}
				}
			?>
		</tbody>
	</table>
</div>
