<?php
	include_once 'ObjectAthlete.php';
	include_once 'ObjectAttempt.php';
	include_once 'ObjectChallenge.php';
	
	$currentChallenge = Challenge::GetCurrent();
	$currentChallengeId = $currentChallenge->ChallengeId;
	
	$selectedChallenge = $currentChallenge;
	$selectedChallengeId = $currentChallengeId;
	
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		if ($_POST["action"] == "ADD-ATTEMPT")
		{
			$seconds = $_POST['challengeTime'];
			$distance = $_POST['challengeDistance'];
			if ($_POST['challengeType']=="D")
			{
				$seconds = 3600*$_POST['hours'] + 60*$_POST['minutes']
			         	+ $_POST['seconds'] + $_POST['fracsec'];
			}
			else
			{
				$distance = $_POST['meters'];
			}
			
			$attempt = new Attempt($_POST['athlete'], $_POST['challengeId'], 
				$distance, $seconds, $_POST['weight'], $_POST['spm']);
	
			$attempt->Save();
			$currentChallenge = Challenge::GetById($_POST["challengeId"]);
		}
		else if ($_POST["action"] == "SIGN-UP")
		{
			$newAthlete = new Athlete(0, $_POST['athlete'], $_POST['gender']);
			$newAthlete->Save();
		}
	}
	elseif ($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['id']))
	{
		$selectedChallenge = Challenge::GetById($_GET['id']);
		$selectedChallengeId = $selectedChallenge->ChallengeId;
	}
	
	$athletes = Athlete::GetAll();
	
	$challenges = Challenge::GetAll();
	$attempts = Attempt::GetForChallenge($selectedChallengeId);
	
	function FormatSection($challenge)
	{
		return $challenge->ChallengeYear()." - ".($challenge->ChallengeYear() + 1);
	}
	
	function FormatChallenge($challenge)
	{
		return Challenge::FormatMonthAndYear($challenge)."<br>".$challenge->Name;
	}
?>
<!DOCTYPE HTML>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Team Oarsome Challenge</title>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<link rel="shortcut icon" href="img/TO.ico" />
		<script type="text/javascript" src="style/nav.js"></script>
		<script type="text/javascript">

        // copyright 1999 Idocs, Inc. http://www.idocs.com
        // Distribute this script freely but keep this notice in place
		function numbersonly(myfield, e, dec)
		{
			var key;
			var keychar;

			if (window.event)
   				key = window.event.keyCode;
			else if (e)
   				key = e.which;
			else
   				return true;
   			
			keychar = String.fromCharCode(key);

            // control keys
			if ((key==null) || (key==0) || (key==8) || 
    			(key==9) || (key==13) || (key==27) )
   				return true;
            // numbers
			else if ((("0123456789").indexOf(keychar) > -1))
   				return true;
            // decimal point jump
			else if (dec && (keychar == "."))
   		    {
   				myfield.form.elements[dec].focus();
   				return false;
   		    }
			else
   				return false;
		}

		</script>
	</head>
	
	<body onload="new Accordian('basic-accordian',5,'header_highlight');">
		  <div id="logo">
			<img src="style/TObanner.png" alt="TO Banner">
  		  </div>
  		  
  		  <div id = "menu">
  	  		<div id="basic-accordian" >
					<?php 
						$sectionYear = 0;
						$foundCurrent = FALSE;
						foreach($challenges as $challenge)
						{
							if ($foundCurrent == FALSE && $challenge->ChallengeId == $currentChallenge->ChallengeId)
							{
								$foundCurrent = TRUE;
								$divClass = "accordion_headings";
								if ($currentChallengeId == $selectedChallengeId)
								{
									$divClass = "accordion_headings header_highlight";
								}
				    			echo '<div id="current-header" class="'.$divClass.'">Current Challenge</div>';
					    			echo '<div id="current-content">';
						      			echo '<div class="accordion_child">';
						      				echo '<a class="navlink" href="TOchallenge.php">'.FormatChallenge($challenge).'</a>';
						      			echo '</div>';
							}
							elseif ($foundCurrent)
							{
								if ($sectionYear != $challenge->ChallengeYear())
								{
									$sectionYear = $challenge->ChallengeYear();
									
									echo '</div>';
								
									$divClass = "accordion_headings";
									if ($challenge->ChallengeYear() == $selectedChallenge->ChallengeYear() &&
									    $currentChallengeId != $selectedChallengeId)
									{
										$divClass = "accordion_headings header_highlight";
									}
									
					    			echo '<div id="section'.$sectionYear.'-header" class="'.$divClass.'">'.FormatSection($challenge).'</div>';
					    			echo '<div id="section'.$sectionYear.'-content">';
								}
								
						      			echo '<div class="accordion_child">';
						      				echo '<a class="navlink" href="TOchallenge.php?id='.$challenge->ChallengeId.'">'.FormatChallenge($challenge).'</a>';
						      			echo '</div>';
							}
						}
						echo '</div>';
					?>
  			</div>
  		</div>
		
		
			<div id="challenge">
				<br><h1><?php echo $selectedChallenge->FormattedDate(); ?></h1>
				<h2><?php echo $selectedChallenge->Name; ?></h2>
				<br><blockquote><?php echo $selectedChallenge->Description; ?></blockquote>
				<table>
			<tr>
				<th>Rower</th>
				<th>Distance</th>
				<th>Time</th>
				<th>Pace</th>
				<th>Gain</th>
				<th>spm</th>
				<th>Pace Points</th>
				<th>Gain Points</th>
				<th>Total Pace</th>
				<th>Total Gain</th>
				<th>Total</th>
			<?php 
			foreach($attempts as $attempt)
			{
				$pace = "";
				if ($attempt->Distance > 0)
				{
					$pace = $attempt->Time / ($attempt->Distance/500);
				}
				$total = $attempt->TotalGainPoints + $attempt->TotalPacePoints;
				echo "<tr>";
				echo "<td>".$attempt->AthleteName."</td>";
				echo "<td>".$attempt->Distance."</td>";
				echo "<td>".Challenge::FormatSeconds($attempt->Time)."</td>";
				echo "<td>".Challenge::FormatSeconds($pace)."</td>";
				echo "<td>".round(-$attempt->Gain, 1)."</td>";
				echo "<td>".$attempt->SPM."</td>";
				echo "<td>".$attempt->PacePoints."</td>";
				echo "<td>".$attempt->GainPoints."</td>";
				echo "<td>".$attempt->TotalPacePoints."</td>";
				echo "<td>".$attempt->TotalGainPoints."</td>";
				echo "<td>".$total."</td>";

				echo "</tr>";
			}
			?>
		</table>
		<div id="entry">	
            <?php if ($selectedChallenge->ChallengeId == $currentChallengeId) {?>
			<form action="TOchallenge.php" method="POST">
			<input type="hidden" name="challengeId" value="<?php echo $currentChallenge->ChallengeId ?>"/>
			<input type="hidden" name="challengeType" value="<?php echo $currentChallenge->Type ?>"/>
			<input type="hidden" name="challengeTime" value="<?php echo $currentChallenge->Time ?>"/>
			<input type="hidden" name="challengeDistance" value="<?php echo $currentChallenge->Distance ?>"/>
			<input type="hidden" name="action" value="ADD-ATTEMPT"/>
			<div id="rower">
			Rower:
				<select name="athlete">
					<?php 

					foreach($athletes as $athlete)
					{
						echo "<option value='$athlete->AthleteId'>$athlete->Name</option>\n";
					}
					?>
				</select>
			</div>
			<?php 
			if ($currentChallenge->Type == "T")
			{
				echo '<div id="meters">Meters <input name="meters" size="5" maxlength="5" onkeypress="return numbersonly(this, event)"></div>';
			}
			else
			{
				echo '<div id="time">Hours: <select name="hours">';
				for ($x=0; $x<=3; $x++)
  					{
  					echo "<option>$x</option>";
  					} 
				echo '</select>Min: <select name="minutes">';
				for ($x=0; $x<=59; $x++)
  				{
  					echo "<option>$x</option>";
  				} 

				echo '</select>Sec:  <select name="seconds">';

				for ($x=0; $x<=59; $x++)
  				{
  					echo "<option>$x</option>";
  				} 

					echo '</select><select name="fracsec">';

				for ($x=0; $x<=9; $x++)
  				{
  					$y=$x*.1;
  					echo "<option>$y</option>";
  				} 
				echo '</select></div>';
			}
			?>

			<div id="strokerate">
				SPM: <input name="spm" size="2" maxlength="2"
				onkeypress="return numbersonly(this, event)"> 
			</div>
			
			<div id="weightclass">
			Weight:
				<select name="weight">
					<option value='H'>Heavyweight </option>
					<option value='L'>Lightweight </option>

				</select>
			</div>
			
			<div id="button">
			<input type="SUBMIT" value="WOOHOO!">
			</div>
			</form>
            <?php }?>
		</div>
		</div>
</body>
</head>
</html>
