<?php
	include_once 'ObjectAthlete.php';
	include_once 'ObjectAttempt.php';
	include_once 'ObjectChallenge.php';
	
	$currentChallenge = Challenge::GetCurrent();
	$currentChallengeId = $currentChallenge->ChallengeId;
	
	$selectedChallenge = $currentChallenge;
	$selectedChallengeId = $currentChallengeId;
	
	$openEntry = false;
	
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
	elseif ($_SERVER['REQUEST_METHOD']=="GET")
	{
		if (isset($_GET['id'])) {
			$selectedChallenge = Challenge::GetById($_GET['id']);
			$selectedChallengeId = $selectedChallenge->ChallengeId;
		}

		if (isset($_GET['openEntry'])) {
			$openEntry = true;
		}
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

		function sortTable(n) {
		  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
		  table = document.getElementById("Attempts");
		  switching = true;
		  
		  // Set the sorting direction to descending:
		  dir = "desc";
		  
		  // Make a loop that will continue until no switching has been done
		  while (switching) {
			// Start by saying: no switching is done
			switching = false;
			rows = table.rows;
			// Loop through all table rows (except the first, which contains table headers)
			for (i = 1; i < (rows.length - 1); i++) {
			  // Start by saying there should be no switching:
			  shouldSwitch = false;
			  // Get the two elements you want to compare, one from current row and one from the next 
			  x = rows[i].getElementsByTagName("TD")[n];
			  y = rows[i + 1].getElementsByTagName("TD")[n];
			  // Check if the two rows should switch place, based on the direction, asc or desc 
			  if (dir == "asc") {
				if (Number(x.innerHTML.toLowerCase()) > Number(y.innerHTML.toLowerCase())) {
				  // If so, mark as a switch and break the loop:
				  shouldSwitch = true;
				  break;
				}
			  } else if (dir == "desc") {
				if (Number(x.innerHTML.toLowerCase()) < Number(y.innerHTML.toLowerCase())) {
				  // If so, mark as a switch and break the loop:
				  shouldSwitch = true;
				  break;
				}
			  }
			}
			if (shouldSwitch) {
			  // If a switch has been marked, make the switch and mark that a switch has been done 
			  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			  switching = true;
			  // Each time a switch is done, increase this count by 1 
			  switchcount ++;
			} else {
			  // If no switching has been done AND the direction is "asc", set the direction to "desc" and run the while loop again. 
			  if (switchcount == 0 && dir == "desc") {
				dir = "asc";
				switching = true;
			  }
			}
		  }
		  
		  // update classes for columns that are sortable
		  headers = table.rows[0].getElementsByTagName("th")
		  for (i = 0; i < (headers.length); i++) {
		  c = headers[i]
			if (i == n){
			  if (dir == "asc") {
				c.className = "headerSortUp"
			  }
			  else {
				c.className = "headerSortDown"
			  }
			} else if (i > 5) {
			  c.className = "headerNoSort"
			}
		  }
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
				<table id="Attempts">
				<tr>
				<th>Rower</th>
				<th>Distance</th>
				<th>Time</th>
				<th>Pace</th>
				<th>Gain</th>
				<th>spm</th>
				<th onclick="sortTable(6)" class="headerSortDown">Pace Points</th>
				<th onclick="sortTable(7)" class="headerNoSort">Gain Points</th>
				<th onclick="sortTable(8)" class="headerNoSort">Total Pace</th>
				<th onclick="sortTable(9)" class="headerNoSort">Total Gain</th>
				<th onclick="sortTable(10)" class="headerNoSort">Total</th>
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
				echo "<td title='".$pace."'>".Challenge::FormatSeconds($pace)."</td>";
				echo "<td title='".-$attempt->Gain."'>".round(-$attempt->Gain, 1)."</td>";
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
            <?php if (($selectedChallenge->ChallengeId == $currentChallengeId) or $openEntry) {?>
			<form action="TOchallenge.php" method="POST">
			<input type="hidden" name="challengeId" value="<?php echo $selectedChallenge->ChallengeId ?>"/>
			<input type="hidden" name="challengeType" value="<?php echo $selectedChallenge->Type ?>"/>
			<input type="hidden" name="challengeTime" value="<?php echo $selectedChallenge->Time ?>"/>
			<input type="hidden" name="challengeDistance" value="<?php echo $selectedChallenge->Distance ?>"/>
			<input type="hidden" name="action" value="ADD-ATTEMPT"/>
			<div id="rower">
			Rower:
				<select name="athlete">
				
					<?php 
					echo "<option value='0'></option>\n";
					foreach($athletes as $athlete)
					{
						echo "<option value='$athlete->AthleteId'>$athlete->Name</option>\n";
					}
					?>
					
				</select>
			</div>
			
			<?php 
			if ($selectedChallenge->Type == "T")
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
