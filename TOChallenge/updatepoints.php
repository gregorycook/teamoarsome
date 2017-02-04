<?php
	include_once 'ObjectAthlete.php';
	include_once 'ObjectChallenge.php';
	include_once 'ObjectAttempt.php';
	
	//echo "Test: Can get challenges.... ";
	//$challenges = Challenge::GetAll();
	//if(is_array($challenges) && count($challenges) > 0){
	//	echo "Passed.<br>";
	//}
	//else{
	//	echo "Failed.<br>";
	//}
	
	//echo "Test: Can add challenge.... ";
	//$challenge = new Challenge(-1, "10x1' R1", 2, 2015, "T", "10x1' R1", 0, 600);
	//$challengeId = $challenge->Save();
	//$challenge = Challenge::GetById($challengeId);
	//if (isset($challenge) && $challenge->ChallengeId == $challengeId){
	//	Challenge::DeleteById($challengeId);
	//	echo "Passed.<br>";
	//}
	//else{
	//	echo "Failed.<br>";
	//}
	
	//echo $_SERVER['REQUEST_METHOD']."<br>";
	
	//$athletes = Athlete::GetAll();
	//foreach($athletes as $athlete)
	//{
	//	echo $athlete->Name."<br>";
	//}
	
	/*
	$challenges = Challenge::GetAll();
	foreach($challenges as $c)
	{
		echo $c->ChallengeId.", ".$c->Name."<br>";
	}
	*/
	
	/* Remember to escape ' such as "8 x 2\' r2"  */
	/*
	$challenge = new Challenge(1, "8 x 2 r2", 1, 2017, "T", "Row for 2 minutes then rest 2 minutes.  Then do that 7 more times.  Record the distance rowed in the sixteen non-rest minutes.", 0, 960);
	$challengeId = $challenge->Save();
	
	$lastChallenge = Challenge::GetById($challengeId);
	$lastChallenge->MakeCurrent();
	*/
	
	$challenges = Challenge::GetAll();
	$reversed = array_reverse($challenges);
	foreach($reversed as $c)
	{
		Attempt::UpdatePoints($c->ChallengeId);
	}
	
	// Attempt::UpdatePoints();
?>