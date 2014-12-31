<?php
	include_once 'ObjectAthlete.php';
	include_once 'ObjectChallenge.php';
	
	echo "Test: Can get challenges.... ";
	$challenges = Challenge::GetAll();
	if(is_array($challenges) && count($challenges) > 0){
		echo "Passed.<br>";
	}
	else{
		echo "Failed.<br>";
	}
	
	echo "Test: Can add challenge.... ";
	$challenge = new Challenge(-1, "test description", 6, 1990, "T", "test name", 0, 1800);
	$challengeId = $challenge->Save();
	$challenge = Challenge::GetById($challengeId);
	if (isset($challenge) && $challenge->ChallengeId == $challengeId){
		Challenge::DeleteById($challengeId);
		echo "Passed.<br>";
	}
	else{
		echo "Failed.<br>";
	}
	
	//echo $_SERVER['REQUEST_METHOD']."<br>";
	
	//$athletes = Athlete::GetAll();
	//foreach($athletes as $athlete)
	//{
	//	echo $athlete->Name."<br>";
	//}
	
	//$challenge = new Challenge(1, "30 minutes, no restriction", 6, 2014, 'T', "A KK", 0, 1800);
	//$challenge->Save();
	
	//$challenges = Challenge::GetAll();
	//foreach($challenges as $c)
	//{
	//	echo $c->ChallengeId.", ".$c->Name."<br>";
	//}
	
	//$lastChallenge = $challenges[Count($challenges) - 1];
	//$lastChallenge = Challenge::GetById(35);
	//$lastChallenge->MakeCurrent();
	
	//$currentChallenge = Challenge::GetCurrent();
	//echo $currentChallenge->ChallengeId.", ".$currentChallenge->Name."<br>";
?>