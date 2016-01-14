<?php
	include_once 'ObjectChallenge.php';
	
	$challenge = new Challenge(-1, "1 x (1K, 4' rest) + 2 x (750, 3' rest) + 2 x (500, 2' rest) + 2 x (250, 1' rest)", 1, 2015, "D", "An easier 4 x 1K", 4000, 0);
	$challengeId = $challenge->Save();
	echo $challengeId;
	$challenge->ChallengeId = $challengeId;
	
	$challenge-> MakeCurrent();
?>