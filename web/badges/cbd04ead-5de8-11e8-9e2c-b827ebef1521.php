<?php

// Milkyway test

$sProjectID="cbd04ead-5de8-11e8-9e2c-b827ebef1521";

$statsurl="https://milkyway.cs.rpi.edu/milkyway/stats/user.gz";
$fp = gzopen($statsurl, "r");

while ($fp && !feof($fp)) {
	$line=fgets($fp);

    if (preg_match('/<id>([0-9]+)<\/id>/',$line,$ida) > 0) {
		if ($ida[1] == 175) {		// replace 175 with db call to find our user id
			while (preg_match('/<\/user>/',$line) < 1) {
				$line=fgets($fp);
				if (preg_match('/<create_time>(.*)<\/create_time>/',$line,$ct) > 0) {
					$create_time=$ct[1];
				} elseif (preg_match('/<total_credit>(.*)<\/total_credit>/',$line,$tc) > 0) {
					$total_credit=$tc[1];
				}
			}
			$fp = FALSE;
			
		}
	}
}
   
if ($total_credit > 100) {
	echo "Badge:  First Work Unit completed!\n";
	echo " .. " & $total_credit & "\n";
}

$iCurrentTime = time();
if ($iCurrentTime > (strtotime('+11 years', $create_time))) {	// no badge here yet, just a dummy test
	echo "Badge:  11 Years!!\n";
} elseif ($iCurrentTime > (strtotime('+10 years', $create_time))) {
	echo "Badge:  10 Years!!\n";
} elseif ($iCurrentTime > (strtotime('+9 years', $create_time))) {
	echo "Badge:  9 Years!!\n";
} elseif ($iCurrentTime > (strtotime('+8 years', $create_time))) {
	echo "Badge:  8 Years!!\n";
} elseif ($iCurrentTime > (strtotime('+7 years', $create_time))) {
	echo "Badge:  7 Years!!\n";
} elseif ($iCurrentTime > (strtotime('+6 years', $create_time))) {
	echo "Badge:  6 Years!!\n";
} elseif ($iCurrentTime > (strtotime('+5 years', $create_time))) {
	echo "Badge:  5 Years!!\n";
} elseif ($iCurrentTime > (strtotime('+4 years', $create_time))) {
	echo "Badge:  4 Years!!\n";
} elseif ($iCurrentTime > (strtotime('+3 years', $create_time))) {
	echo "Badge:  3 Years!!\n";
} elseif ($iCurrentTime > (strtotime('+2 years', $create_time))) {
	echo "Badge:  2 Years!!\n";
} elseif ($iCurrentTime > (strtotime('+1 years', $create_time))) {
	echo "Badge:  1 Year!!\n";
}

?>