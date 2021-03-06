<?php
	include_once 'MySql.php';
	
	class Athlete
	{
		var $AthleteId;
		var $Name;
		var $Gender;
		
		function __construct($athleteId, $name, $gender)
		{
			$this->AthleteId = $athleteId;
			$this->Name = $name;
			$this->Gender = $gender;
		}
		
		function Save()
		{
			try{
			
			$deleteSQL = "delete from athlete where id=".$this->AthleteId;
			ExecuteStatement($deleteSQL);
			
			$insertSQL = "insert into athlete(Name, Gender)values('".$this->Name."','".$this->Gender."')";
			return ExecuteStatement($insertSQL);}
			catch (Exception $e){
				print($e->getMessage());
			}
		}
		
	static function GetAll()
		{
			$selectSQL = "
select ath.*
  from athlete ath left outer join (select a.AthleteId,
                                           count(1) thingy
                                      from attempt a,
                                           challenge c
                                     where a.ChallengeId = c.Id
                                       and (12 * year(curdate()) + month(curdate()) - 24 < c.Month + (12 * c.Year))
                                  group by a.AthleteId) x
                   on x.AthleteId = ath.Id
order by isnull(x.thingy),
       ath.Name";
			$athleteRecords = GetSelectResult($selectSQL);
			
			$athletes = array();
			foreach ($athleteRecords as $athleteRecord)
			{
				$athletes[count($athletes)] = new Athlete($athleteRecord["Id"],
				$athleteRecord['Name'], $athleteRecord['Gender']);
			}
			
			return $athletes;
		}
		
		    
		    static function GetAllAsJson()
		    {
		        return json_encode(Athlete::GetAll());
		    }
	}
?>