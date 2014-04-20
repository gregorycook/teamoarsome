<?php
	include_once 'MySql.php';
	
	class Athlete
	{
		var $AthleteId;
		var $Name;
		var $Gender;
		
		function Athlete($athleteId, $name, $gender)
		{
			$this->AthleteId = $athleteId;
			$this->Name = $name;
			$this->Gender = $gender;
		}
		
		function Save()
		{
			$deleteSQL = "delete from athlete where id=".$this->AthleteId;
			ExecuteStatement($deleteSQL);
			
			$insertSQL = "insert into athlete(Name, Gender)values('".$this->Name."','".$this->Gender."')";
			ExecuteStatement($insertSQL);
		}
		
	static function GetAll()
		{
			$selectSQL = "select * from athlete order by Name";
			$athleteRecords = GetSelectResult($selectSQL);
			
			$athletes = array();
			foreach ($athleteRecords as $athleteRecord)
			{
				$athletes[count($athletes)] = new Athlete($athleteRecord["Id"],
				$athleteRecord['Name'], $athleteRecord['Gender']);
			}
			
			return $athletes;
		}
	}
?>