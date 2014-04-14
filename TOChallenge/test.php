<?php
	include_once 'ObjectAthlete.php';
	include_once 'ObjectChallenge.php';
	
	$athletes = Athlete::GetAll();
	foreach($athletes as $athlete)
	{
		echo $athlete->Name."<br>";
	}
	
	$challenge = new Challenge(1, "5K", 5, 2014, 'D', "A 5K", 5000, 0);
	$challenge->Save();
	
	$challenges = Challenge::GetAll();
	foreach($challenges as $c)
	{
		echo $c->Name;
	}
?>