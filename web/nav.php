<nav class="navbar navbar-expand-md fixed-top navbar-userstats">
	<div class = "container">
	<a href="<?php echo $hp_nav_brand_link; ?>"><img class="navbar-brand" src="<?php echo $brand_logo; ?>" width="30px" alt="logo"></a>
		<a class="navbar-brand" href="./index.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#moreLinks" aria-controls="moreLinks" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="moreLinks">
			<ul class="navbar-nav">
				<?php
					echo "<li class='nav-item'>";
					echo "<a class='nav-link' href='./index.php' class='btn btn-neutral btn-simple'><i class='fa fa-home' aria-hidden='true'></i> " . $linkNameOverview . "</a>";
					echo "</li>";
					// sind laufende WUs im Internet ersichtlich
					if ( $hasBoinctasks ) {
						echo "<li class='nav-item'>";
						echo "<a class='nav-link' href='" . $linkBoinctasks . "' class='btn btn-neutral btn-simple'><i class='fa fa-tasks'></i> " . $linkNameBoinctasks . "</a>";
						echo "</li>";
					};
					// Pendings
					if ( $hasPendings ) {
						echo "<li class='nav-item'>";
						echo "<a class='nav-link' href='" . $linkPendings . "' class='btn btn-neutral btn-simple'><i class='fa fa-refresh'></i> " . $linkNamePendings . "</a>";
						echo "</li>";
					};
					// Link zu Team
					if ( $hasTeamHp ) {
						echo "<li class='nav-item'>";
						echo "<a class='nav-link' href='" . $teamHpURL . "' target='_new' class='btn btn-neutral btn-simple'><i class='fa fa-globe'></i> " . $teamHpName . "</a>";
						echo "</li>";
					};
					// Link zu Boinctasks
						if ( $hasBoincstats ) {
						echo "<li class='nav-item'>";
						echo "<a class='nav-link' href='" . $linkBoincstats . "' target='_new' class='btn btn-neutral btn-simple'><i class='fa fa-bar-chart'></i> " . $linkNameBoincstats . "</a>";
						echo "</li>";
					};
					// Link zu WCG
					if ( $hasWcg ) {
						echo "<li class='nav-item'>";
						echo "<a class='nav-link' href='" . $linkWcg . "' target='_new' class='btn btn-neutral btn-simple'><i class='fa fa-globe'></i> " . $linkNameWcg . "</a>";
						echo "</li>";
					};
					// individuelle Links aus settings.php
					if ($showLinks) { 
						echo '
						<li class="nav-item">
							<a class="nav-link" href="' . $hp_nav_link01 . '" class="btn btn-neutral">' . $hp_nav_name01 . '</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="' . $hp_nav_link02 . '" class="btn btn-neutral">' . $hp_nav_name02 . '</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="' . $hp_nav_link03 . '" class="btn btn-neutral">' . $hp_nav_name03 . '</a>
						</li>';
					};
					// weitere Links zu Seiten von SG, WCG und Dev
					if ($showMoreLinks) { 
						echo '
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-info-circle" aria-hidden="true"></i> ' . $showMoreLinksName . '</a>
							<div class="dropdown-menu" aria-labelledby="dropdownId">
								<a class="dropdown-item" href="https://github.com/XSmeagolX" target="_new"><i class="fa fa-github" aria-hidden="true"></i> Userstats on GitHub</a>
								<a class="dropdown-item" href="https://userstats.timo-schneider.de" target="_new"><i class="fa fa-home" aria-hidden="true"></i> Userstats Website</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="https://www.seti-germany.de" target="_new"><i class="fa fa-globe" aria-hidden="true"></i> SETI.Germany</a>
								<a class="dropdown-item" href="https://join.worldcommunitygrid.org/?recruiterId=653215&teamId=4VVG5BDPP1" target="_new"><i class="fa fa-globe" aria-hidden="true"></i> World Community Grid</a>
							</div>
						</li>
						';
					};
				?>
			</ul>
		</div>
	</div>
</nav>
<!-- End Navbar -->
