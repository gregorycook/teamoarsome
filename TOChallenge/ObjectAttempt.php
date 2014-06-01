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
	var $PacePoints;
	var $GainPoints;
	var $TotalPacePoints;
	var $TotalGainPoints;
	
	function Attempt($attemptId, $athleteId, $athleteName, $challengeId, $distance, $time, 
		$weight, $entered, $spm, $pacePoints, $gainPoints, $totalPacePoints, $totalGainPoints)
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
		$this->PacePoints = $pacePoints;
		$this->GainPoints = $gainPoints;
		$this->TotalPacePoints = $totalPacePoints;
		$this->TotalGainPoints = $totalGainPoints;
	}
	
	function Save()
	{
		$deleteSQL = "delete from attempt where AthleteId=".$this->AthleteId." and ChallengeId=".$this->ChallengeId;
		ExecuteStatement($deleteSQL);
		
		$insertSQL = "insert into attempt(AthleteId, ChallengeId, Distance, Time, Weight, Entered, SPM)
		              values(".$this->AthleteId.",".
		                       $this->ChallengeId.",".
		                       $this->Distance.",".
		                       $this->Time.",".
		                       "'".$this->Weight."',".
		                       "Now(),".
		                       $this->SPM.")";

		ExecuteStatement($insertSQL);
		
		Attempt::UpdatePoints($this->ChallengeId);
	}

	private static function CreateFromRecord($r)
	{
		return new Attempt(
				$r['Id'], $r['AthleteId'], $r['AthleteName'], 
				$r['ChallengeId'], $r['Distance'], $r['Time'],
				$r['Weight'], $r['Entered'], $r['SPM'], $r['PacePoints'], $r['GainPoints'],
				$r['TotalPacePoints'], $r['TotalGainPoints']);
	}
	
	static function GetForChallenge($challengeId)
	{
		$selectSQL = 
"SELECT a.Id, 
		ath.Id AthleteId,
		ath.Name AthleteName,
		sp.ChallengeId,
		a.Distance,
		a.Time,
		a.Weight,
		a.Entered,
		a.SPM,
		ifnull(a.PacePoints, 0) PacePoints,
		ifnull(a.GainPoints, 0) GainPoints,
		ifnull(sp.PacePoints, 0) TotalPacePoints,
		ifnull(sp.GainPoints, 0) TotalGainPoints
   FROM athlete ath join summary_points sp on (sp.ChallengeId = $challengeId and sp.AthleteId = ath.Id )
		 left outer join attempt a on (a.AthleteId = ath.Id and a.ChallengeId = sp.ChallengeId)
order by a.PacePoints + a.GainPoints desc,
       sp.PacePoints + sp.GainPoints desc";
		
		$attemptRecords = GetSelectResult($selectSQL);
	
		$attempts = array();
		foreach ($attemptRecords as $r)
		{
			$attempts[count($attempts)] = Attempt::CreateFromRecord($r);
		}
	
		return $attempts;
	}
	
	private static function UpdatePoints($challengeId)
	{
		$challenge = Challenge::GetById($challengeId);
		
		if (!($challenge->Month == 5))
		{
			Attempt::UpdateGainPoints($challengeId);
		}
		Attempt::UpdatePacePoints($challengeId);
	}
	
	private static function UpdateGainPoints($challengeId)
	{
		$gainSql =
"select x.AthleteId,
        x.this_pace,
        y.last_pace
   from (select a.ChallengeId,
                c.Year this_year,
                c.Month this_month,
                a.AthleteId,
                a.Time/(a.Distance/500) this_pace
           from attempt a,
                challenge c
          where a.ChallengeId = c.Id) x left outer join
        (select c.Year last_year,
                c.Month last_month,
                a.AthleteId,
                a.Time/(a.Distance/500) last_pace
           from attempt a,
                challenge c
          where a.ChallengeId = c.Id) y on (x.AthleteId = y.AthleteId and 12*x.this_year + x.this_month = 12*y.last_year + y.last_month + 1) 
  where ChallengeId = $challengeId
order by this_pace - last_pace";
		
		$attemptRecords = GetSelectResult($gainSql);
	
		$points = 1;
		foreach ($attemptRecords as $r)
		{
			if (isset($r["last_pace"]))
			{
				$athleteId = $r["AthleteId"];
				$updateStatement = "update attempt set GainPoints=$points where ChallengeId=$challengeId and AthleteId=$athleteId";
				ExecuteStatement($updateStatement);
			}
			$points++;
		}
	}
	
	private static function UpdatePacePoints($challengeId)
	{
		$paceSql =
"SELECT a.AthleteId,
		a.Distance,
		a.Time
   FROM attempt a
 where a.ChallengeId = $challengeId
order by a.Distance/a.Time";
		
		$attemptRecords = GetSelectResult($paceSql);
	
		$points = 1;
		foreach ($attemptRecords as $r)
		{
			$athleteId = $r["AthleteId"];
			$updateStatement = "update attempt set PacePoints=$points where ChallengeId=$challengeId and AthleteId=$athleteId";
			ExecuteStatement($updateStatement);
				
			$points++;
		}
	}
}
?>