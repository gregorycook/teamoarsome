<?php
	include_once 'ObjectAthlete.php';
	include_once 'ObjectAttempt.php';
	include_once 'ObjectChallenge.php';
	
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		$seconds = $_POST['challengeTime'];
		$distance = $_POST['challengeDistance'];
		if ($_POST['challengeType']=="D")
		{
			$seconds = 3600*$_POST['hours'] + 60*$_POST['minutes']
		         	+ $_POST['seconds'] + $_POST['fracsec']/10;
		}
		else
		{
			$distance = $_POST['meters'];
		}
		$attempt = new Attempt(0, $_POST['athlete'], '',
			$_POST['challengeId'], $distance, $seconds, $_POST['weight'], 0, $_POST['spm']);

		$attempt->Save();
	}
	
	$athletes = Athlete::GetAll();
	$currentChallenge = Challenge::GetCurrent();
	
	$attempts = Attempt::GetForChallenge($currentChallenge->ChallengeId);

	function FormatSeconds($seconds)
	{
		$minutesPart = floor($seconds/60);
		$secondPart = ($seconds - 60*$minutesPart);
		
		return $minutesPart.":".str_pad(number_format($secondPart, 1), 4, "0", STR_PAD_LEFT);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Team Oarsome Challenge</title>
		<link rel="stylesheet" type="text/css" href="TOstyle.css">
		<link rel="shortcut icon" href="img/TO.ico" />
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
	
	<body>

		<div id="banner" > <img src="img/TObanner.png" alt="logo"></div>

		<form action="TOchallenge.php" method="POST">
			<input type="hidden" name="challengeId" value="<?php echo $currentChallenge->ChallengeId ?>"/>
			<input type="hidden" name="challengeType" value="<?php echo $currentChallenge->Type ?>"/>
			<input type="hidden" name="challengeTime" value="<?php echo $currentChallenge->Time ?>"/>
			<input type="hidden" name="challengeDistance" value="<?php echo $currentChallenge->Distance ?>"/>
			<input type="hidden" name="action" value="ADD-ATTEMPT"/>
			<div id="month">
				Month:
				<select>
					<option>May 2014</option>
					<option>June 2014</option>
					<option>July 2014</option>
				</select>
			</div>
		
			<div id="challenge">
				Challenge:<br><?php echo $currentChallenge->Description; ?>
			</div>

			<div id="name">
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
				echo '<div id="meters">
				Meters <input name="meters" size="5" maxlength="5"
				onkeypress="return numbersonly(this, event)"> 
				</div>';
			}
			else
			{
				echo '<div id="time"> 
					Hours: <select name="hours">';
				for ($x=0; $x<=3; $x++)
  					{
  					echo "<option>$x</option>";
  					} 
				echo '</select>
					Min: <select name="minutes">';
				for ($x=0; $x<=59; $x++)
  				{
  					echo "<option>$x</option>";
  				} 

				echo '</select>
						Sec:  <select name="seconds">';

				for ($x=0; $x<=59; $x++)
  				{
  					echo "<option>$x</option>";
  				} 

					echo '</select>
						<select name="fracsec">';

				for ($x=0; $x<=9; $x++)
  				{
  					$y=$x*.1;
  					echo "<option>$y</option>";
  				} 
				echo '</select>
					</div>';
			}
			?>

			<div id="strokerate">
				SPM: <input name="spm" size="2" maxlength="2"
				onkeypress="return numbersonly(this, event)"> 
			</div>
			
			<div id="weightclass">
			Weight:
				<select name="weight">
					<option value='H'>heavyweight </option>
					<option value='L'>lightweight </option>

				</select>
			</div>
			
			<div id = "button">
			<input type="SUBMIT" value="WOOHOO!"></div>s
		</form>
		<form action="TOchallenge.php" method="POST">
			<input type="hidden" name="action" value="SIGN-UP"/>
			<div id="enter">
				Name: <input name="athlete" size="20" maxlength="50">
				<select name="gender">
					<option value='M'>Male</option>
					<option value='F'>Female</option>
				</select>
			</div>
			<div id="signupbutton">
			<input type="SUBMIT" value="Sign up!">
			</div>
		</form>

		<table>
			<tr>
				<td style = 'font-weight:bold'>Athlete</td>
				<td style = 'font-weight:bold'>Distance</td>
				<td style = 'font-weight:bold'>Time</td>
				<td style = 'font-weight:bold'>Pace</td>
				<td style = 'font-weight:bold'>spm</td>
<!--				<td>pace<br>gain</td>-->
<!--				<td>pace<br>pts</td>-->
<!--				<td>gain<br>pts</td>-->
<!--				<td>all<br>pts</td>-->
<!--				<td>pace<br>total</td>-->
<!--				<td>gain<br>total</td>-->
<!--				<td>all<br>total</td>-->
			<?php 
			foreach($attempts as $attempt)
			{
				$pace = $attempt->Time / ($attempt->Distance/500);
				echo "<tr>";
				echo "<td>".$attempt->AthleteName."</td>";
				echo "<td>".$attempt->Distance."</td>";
				echo "<td>".FormatSeconds($attempt->Time)."</td>";
				echo "<td>".FormatSeconds($pace)."</td>";
				echo "<td>".$attempt->SPM."</td>";

				echo "</tr>";
			}
			?>
		</table>
		
</body>
</head>
</html>
