<?php
include_once 'MySql.php';

class Attempt
{
	var $AttemptId;
	var $AthleteId;
	var $AthleteName;
	var $ChallengeId;
	var $Distance;
	var $Time;
	var $Weight;
	var $Entered;
	var $SPM;
	
	function Attempt($attemptId, $athleteId, $athleteName,
		$challengeId, $distance, $time, $weight, $entered, $spm)
	{
		$this->AttemptId = $attemptId;
		$this->AthleteId = $athleteId;
		$this->AthleteName = $athleteName;
		$this->ChallengeId = $challengeId;
		$this->Distance = $distance;
		$this->Time = $time;
		$this->Weight = $weight;
		$this->Entered = $entered;
		$this->SPM = $spm;
	}
	
	function Save()
	{
		$insertSQL = "insert into Attempt(AthleteId, ChallengeId, Distance, Time, Weight, Entered, SPM)
		              values(".$this->AthleteId.",".
		                       $this->ChallengeId.",".
		                       $this->Distance.",".
		                       $this->Time.",".
		                       "'".$this->Weight."',".
		                       "Now(),".
		                       $this->SPM.")";
		echo $insertSQL;
		ExecuteStatement($insertSQL);
	}

	private static function CreateFromRecord($r)
	{
		return new Attempt(
				$r['Id'], $r['AthleteId'], $r['AthleteName'], 
				$r['ChallengeId'], $r['Distance'], $r['Time'],
				$r['Weight'], $r['Entered'], $r['SPM']);
	}
	
	static function GetForChallenge($challengeId)
	{
		$selectSQL = 
"SELECT a.Id, 
		a.AthleteId,
		a.Name AthleteName,
		a.ChallengeId,
		a.Distance,
		a.Time,
		a.Weight,
		a.Entered,
		a.SPM
   FROM attempt a,
        athlete ath,
        (select AthleteId,
                ChallengeId,
                Max(Entered) AttemptDate
           from attempt
       group by AthleteId,
                ChallengeId) x
 where x.AthleteId = a.AthleteId
   and a.AtheteId = ath.Id
   and x.ChallengeId = a.ChallengeId
   and x.AttemptDate = a.Entered
   and a.ChallengeId = ".$challengeId;
		
		$attemptRecords = GetSelectResult($selectSQL);
	
		$attempts = array();
		foreach ($attemptRecords as $r)
		{
			$attempts[count($attempts)] = Attempt::CreateFromRecord($r);
		}
	
		return $attempts;
	}
}
?>