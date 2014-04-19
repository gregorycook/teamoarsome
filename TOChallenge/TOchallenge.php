<?php
	include_once 'ObjectAthlete.php';
	include_once 'ObjectAttempt.php';
	include_once 'ObjectChallenge.php';
	
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		$seconds = 3600*$_POST['hours'] + 60*$_POST['minutes']
		         + $_POST['seconds'] + $_POST['fracsec']/10;
		$attempt = new Attempt(0, $_POST['athlete'], '',
			$_POST['challengeId'], $_POST['meters'], $seconds, "L", 0, 0);
		echo $_POST['hours']."<br>";
		echo $_POST['minutes']."<br>";
		echo $_POST['seconds']."<br>";
		echo $_POST['fracsec']."<br>";
		//$attempt->Save();
	}
	
	$athletes = Athlete::GetAll();
	$currentChallenge = Challenge::GetCurrent();
	
	$attempts = Attempt::GetForChallenge($currentChallenge->ChallengeId);
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
			<div id="month">
				Month:
				<select>
					<option>May 2014</option>
					<option>June 2014</option>
					<option>July 2014</option>
				</select>
			</div>
		
			<div id="challenge">
				Challenge:<br>Row as fast as you can for as long as you can
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
	
			<div id="meters">
				Meters <input name="meters" size="5" maxlength="5"
				onkeypress="return numbersonly(this, event)"> 
			</div>
			<div id="time">
				Hours:
				<select name="hours">
				<?php 
				for ($x=0; $x<=3; $x++)
  				{
  					echo "<option>$x</option>";
  				} 
				?>
				</select>
				Min:
				<select name="minutes">
				<?php 
				for ($x=0; $x<=59; $x++)
  				{
  					echo "<option>$x</option>";
  				} 
				?>
			</select>
			Sec:
			<select name="seconds">
				<?php 
				for ($x=0; $x<=59; $x++)
  				{
  					echo "<option>$x</option>";
  				} 
				?>
			</select>
			<select name="fracsec">
				<?php 
				for ($x=0; $x<=9; $x++)
  				{
  					$y=$x*.1;
  					echo "<option>$y</option>";
  				} 
				?>
				</select>
			</div>
			<input type="SUBMIT" value="WOOHOO!">
		</form>

		<table>
			<tr>
				<td>Athlete</td>
				<td>Pace</td>
				<td>Time</td>
				<td>spm</td>
				<td>pace<br>gain</td>
				<td>pace<br>pts</td>
				<td>gain<br>pts</td>
				<td>all<br>pts</td>
				<td>pace<br>total</td>
				<td>gain<br>total</td>
				<td>all<br>total</td>
			<?php 
			$athletes = Athlete::GetAll();
			foreach($athletes as $athlete)
			{
				echo "<tr><td>";
				echo $athlete->Name."</td>";
				echo"<td>";
				echo $athlete->Name.</td>;
				
				
				
				
				
				
				echo </tr>";
			}
	
				//$athletes = Athlete::GetAll();
			?>
		</table>
</body>
</head>
</html>
