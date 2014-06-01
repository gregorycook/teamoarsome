<?php
	include_once 'ObjectAthlete.php';
	include_once 'ObjectChallenge.php';
	
	
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
	
	$lastChallenge = $challenges[Count($challenges) - 1];
	$lastChallenge = Challenge::GetById(29);
	$lastChallenge->MakeCurrent();
	
	$currentChallenge = Challenge::GetCurrent();
	echo $currentChallenge->ChallengeId.", ".$currentChallenge->Name."<br>";
?>