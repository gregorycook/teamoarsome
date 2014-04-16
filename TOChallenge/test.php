<?php
	include_once 'ObjectAthlete.php';
	include_once 'ObjectChallenge.php';
	
	$athletes = Athlete::GetAll();
	foreach($athletes as $athlete)
	{
		echo $athlete->Name."<br>";
	}
	
	//$challenge = new Challenge(1, "6K", 6, 2014, 'D', "A KK", 5000, 0);
	//$challenge->Save();
	
	$challenges = Challenge::GetAll();
	foreach($challenges as $c)
	{
		echo $c->ChallengeId.", ".$c->Name."<br>";
	}
	
	$lastChallenge = $challenges[Count($challenges) - 1];
	$lastChallenge->MakeCurrent();
	
	$currentChallenge = Challenge::GetCurrent();
	echo $currentChallenge->ChallengeId.", ".$currentChallenge->Name."<br>";
?>