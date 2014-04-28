<?php
include_once 'MySql.php';

class Challenge
{
	var $ChallengeId;
	var $Name;
	var $Month;
	var $Year;
	var $Type;
	var $Description;
	var $Distance;
	var $Time;
	
	var $NiceDate;
	
	function Challenge($challengeId, $name, $month, $year, $type,
		$description, $distance, $time)
	{
		$this->ChallengeId = $challengeId;
		$this->Name = $name;
		$this->Month = $month;
		$this->Year = $year;
		$this->Type = $type;
		$this->Description = $description;
		$this->Distance = $distance;
		$this->Time = $time;
		
		$this->NiceDate = mktime(12, 1, 1, $this->Month, 1, $this->Year);
	}
	
	function Save()
	{
		$deleteSQL = "delete from challenge where id=".$this->ChallengeId;
		ExecuteStatement($deleteSQL);
		
		$insertSQL = "insert into challenge(Name, Month, Year, Type, Description, Distance, Time)
		              values('".$this->Name."',".
		                        $this->Month.",".
		                        $this->Year.",".
		                        "'".$this->Type."',".
		                        "'".$this->Description."',".
		                        $this->Distance.",".
		                        $this->Time.")";

		ExecuteStatement($insertSQL);
	}

	function MakeCurrent()
	{
		$updateOldCurrent = "update current set EndActive=Now() where EndActive is null";
		ExecuteStatement($updateOldCurrent);
		
		$insertNewCurrent = "insert into current(ChallengeId) values (".$this->ChallengeId.")";
		ExecuteStatement($insertNewCurrent);
	}

	private static function CreateFromRecord($r)
	{
		return new Challenge(
				$r['Id'], $r['Name'], $r['Month'],
				$r['Year'], $r['Type'], $r['Description'],
				$r['Distance'], $r['Time']);
	}
	
	static function GetCurrent()
	{
		$selectSQL = "select ch.* from challenge ch, current cu where ch.Id = cu.ChallengeId and cu.EndActive is null";
		$challengeRecord = GetSelectResult($selectSQL);

		return Challenge::CreateFromRecord($challengeRecord[0]);
	}
	
	static function GetById($challengeId)
	{
		$selectSQL = "select ch.* from challenge ch where ch.Id = ".$challengeId;
		$challengeRecord = GetSelectResult($selectSQL);

		return Challenge::CreateFromRecord($challengeRecord[0]);
	}
	
	static function GetAll()
	{
		$selectSQL = "select * from challenge order by Year desc, Month desc, Name";
		$challengeRecords = GetSelectResult($selectSQL);
	
		$challenges = array();
		foreach ($challengeRecords as $r)
		{
			$challenges[count($challenges)] = Challenge::CreateFromRecord($r);
		}
	
		return $challenges;
	}
	
	static function FormatSeconds($seconds)
	{
		$minutesPart = floor($seconds/60);
		$secondPart = ($seconds - 60*$minutesPart);
		
		return $minutesPart.":".str_pad(number_format($secondPart, 1), 4, "0", STR_PAD_LEFT);
	}
	
	static function FormatMonthAndYear($challenge)
	{
		$timeParts = getdate($challenge->NiceDate);
		return $timeParts["month"].", ".$timeParts["year"];	
	}
}
?>