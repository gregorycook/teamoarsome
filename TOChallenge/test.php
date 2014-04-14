<?php
	include_once 'ObjectAthlete.php';
	
	$athletes = Athlete::GetAll();
	foreach($athletes as $athlete)
	{
		echo $athlete->Name."<br>";
	}
?>