<?php
	include_once 'ObjectChallenge.php';
	include_once 'ObjectAthlete.php';
	
	$challenges = Challenge::GetAll();

	$currentChallenge = Challenge::GetCurrent();
	$month = date('n');
	
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		if ($_POST["action"] == "ADD-CHALLENGE")
		{
			if ($currentChallenge->Month != $month)
			{
				$success = true;
				$name = $_POST["challengeName"];
				if (!isset($name) or strlen($name) == 0){
					$success = false;
					print("Name is a required field for a new challenge.<br>");
				}
				
				$month = (int)$_POST["challengeMonth"];
				$year = (int)$_POST["challengeYear"];
				$challengeType = $_POST["challengeType"];
				$description = $_POST["description"];
				
				$totalDistance = (int)$_POST["totalDistance"];
				if ($challengeType == "D" and $totalDistance <= 0){
					$success = false;
					print("Distance challenges mush have a Total Distance greater than 0.<br>");
				}
				
				$totalTime = (int)$_POST["totalTime"];
				if ($challengeType == "T" and $totalTime <= 0){
					$success = false;
					print("Time-based challenges mush have a Total Time greater than 0.<br>");
				}
				
				if ($success){
					$challenge = new Challenge(1, $name, $month, $year, $challengeType, $description, $totalDistance, $totalTime);
					$challengeId = $challenge->Save();
					
					$newChallenge = Challenge::GetById($challengeId);
					$newChallenge->MakeCurrent();
				}
			}
		}
		else if ($_POST["action"] == "ADD-ATHLETE")
		{
			$name = $_POST["athleteName"];
			$gender = $_POST["athleteGender"];
			
			try{
			$athlete = new Athlete(0, $name, $gender);
			}
			catch (Exception $e){
				print($e->getMessage()."<br>");
			}
			$athleteId = $athlete->Save();
			if ($athleteId > 0){
			printf("AthleteId = %d, Name = %s Added!", $athleteId, $name);
			}
			else{
				print("Something went horribly wrong when trying to add new team member!");
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Team Oarsome Challenge</title>
		
		<link rel="stylesheet" type="text/css" href="style/ManageStyle.css">
		
		<link rel="shortcut icon" href="img/TO.ico" />
	</head>
	
	<body>
		<div id="banner" > <img src="img/TObanner.png" alt="logo"></div>

		<div id="challenge">
			<h2>Current Challenge</h2>
			<br>(<?php echo $currentChallenge->FormattedDate(); ?>) <?php echo $currentChallenge->Name; ?>
			<br><?php echo $currentChallenge->Description; ?>
		</div>

		<div id="newChallenge">	
			<h2>New Challenge</h2>
			<form action="ManageChallenges.php" method="POST">
			<input class="newChallengeEntry" type="hidden" name="action" value="ADD-CHALLENGE"/>
			<div class="newChallengeEntry2">
			Year: <input class="newChallengeEntry2" type="number" name="challengeYear" size="10" value="<?php echo date('Y') ?>" readonly="readonly" />
			Month: <input class="newChallengeEntry2" type="number" name="challengeMonth" size = "10" value="<?php echo $month ?>" readonly="readonly" /> <br>
			</div>
			Name: <input class="newChallengeEntry" type="text" name="challengeName" maxlength="50" size="50" /> <br>
			Description: <input class="newChallengeEntry" type="text" name="description" maxlength="255" size="50" /> <br>
			Type:<br>
			Distance <input class="newChallengeEntry" type="radio" name="challengeType" value="D" checked="checked">
			Total Distance: <input class="newChallengeEntry" type="number" name="totalDistance" min="0" value="0" max="42195" > <br>
			Time <input class="newChallengeEntry" type="radio" name="challengeType" value="T" style="{left-margin: 60px;}">
			Total Time (in seconds): <input class="newChallengeEntry" type="number" name="totalTime"  min="0" value="0" max="9999" > <br>

			<?php 
				if ($month != $currentChallenge->Month)
				{
					echo '<input class="newChallengeEntry" type="SUBMIT" value="Add Challenge!">';
				}
			?>
			</form>
		</div>

		<div id="newAthlete">	
			<h2>New Team Member</h2>
			<form action="ManageChallenges.php" method="POST">
			<input class="newAthleteEntry" type="hidden" name="action" value="ADD-ATHLETE"/>

			Name: <input class="newAthleteEntry" type="text" name="athleteName" > <br>

			Gender:
			<select class="newAthleteEntry"  name="athleteGender">
				<option class="newAthleteEntry" value='M'>Male</option>
				<option class="newAthleteEntry" selected="selected" value='F'>Female</option>
			</select>
 			<br>
 			<input class="newAthleteEntry" type="SUBMIT" value="Add New Team Member">
		
			</form>
		</div>
		
		<div id="updatePoints">
			<br>
			<a href="/TeamOarsome/updatepoints.php">Update Points</a>
		</div>
	</body>
</html>