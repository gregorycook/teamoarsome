<?php
	include_once 'ObjectChallenge.php';
	
	$challenges = Challenge::GetAll();
	$currentChallenge = Challenge::GetCurrent();
	
	if($_SERVER['REQUEST_METHOD']=="GET")
	{
		echo $_SERVER['REQUEST_METHOD']=="GET"."<br>";
		$currentChallenge = Challenge::GetById($_GET["ChallengeId"]);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Team Oarsome Challenge</title>
		<link rel="stylesheet" type="text/css" href="TOstyle.css">
		<link rel="shortcut icon" href="img/TO.ico" />
	</head>
	
	<body>
		<div id="challenge">
		</div>
		<div id="banner" > <img src="img/TObanner.png" alt="logo"></div>
		<br><br><br>
		<?php
			echo $currentChallenge->Month; 
		?>
		
		<div id="challengeTable">
			<table>
			<tr>
				<td>Date</td>
				<td>Name</td>
				<td>Type</td>
				<td>Total</td>
				<td>Description</td>
			</tr>
			<?php 
				foreach($challenges as $challenge)
				{
					$total = $challenge->Distance." meters";
					$type = "Distance";
					if ($challenge->Type == "T")
					{
							$total = Challenge::FormatSeconds($challenge->Time);
							$type = "Timed";
					}
					echo "<tr>";
					echo "<td><a href='ManageChallenges.php?ChallengeId=".$challenge->ChallengeId."'>".Challenge::FormatMonthAndYear($challenge)."</a></td>";
					echo "<td>".$challenge->Name."</td>";
					echo "<td>".$type."</td>";
					echo "<td>".$total."</td>";
					echo "<td>".$challenge->Description."</td>";
					echo "</tr>";
				}
			?>
			</table>
		</div>
	</body>
</html>