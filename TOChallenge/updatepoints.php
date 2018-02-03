<?php
	include_once 'ObjectAttempt.php';
	include_once 'ObjectChallenge.php';
	
	function FormatChallenge($challenge)
	{
		return Challenge::FormatMonthAndYear($challenge)." --- ".$challenge->Name;
	}
	
	if ($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['id']))
	{
		$startWithChallengeId = $_GET['id'];
	
		$challenges = Challenge::GetAll();
		$reversed = array_reverse($challenges);
		foreach($reversed as $c)
		{
			if ($c->ChallengeId >= $startWithChallengeId) {
				Attempt::UpdatePoints($c->ChallengeId);
			}
		}
		
		header('Location: /TeamOarsome/TOchallenge.php?id='.$startWithChallengeId);
	}
	else
	{
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Team Oarsome Challenge</title>
		
		<link rel="stylesheet" type="text/css" href="style/ManageStyle.css">
		
		<link rel="shortcut icon" href="img/TO.ico" />
	</head>
	
	<body>
<?php
		
		$challenges = Challenge::GetAll();
		foreach($challenges as $c)
		{
      		echo '<a href="updatepoints.php?id='.$c->ChallengeId.'">'.FormatChallenge($c).'</a><br>';
		}
	}
?>
	</body>
	