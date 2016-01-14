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
	
	var $SummaryPointViewSql = 
"select a.AthleteId,
        c.Id ChallengeId,
        sum(a.PacePoints) PacePoints,
        sum(a.GainPoints) GainPoints 
   from attempt a join challenge cmain 
                  join challenge c  
  where (a.ChallengeId = cmain.Id) and 
        (((c.Month <= 4) and (((cmain.Year = c.Year) and (cmain.Month <= c.Month)) or ((cmain.Year + 1 = c.Year) and (cmain.Month >= 5)))) or 
	    ((c.Month >= 5) and (cmain.Year = c.Year) and (cmain.Month <= c.Month) and (cmain.Month >= 5)))
  group by a.AthleteId,
        c.Id";
	
	function __construct($athleteId, $challengeId, $distance, $time, 
		$weight, $spm)
	{
		$this->AthleteId = $athleteId;
		$this->ChallengeId = $challengeId;
		$this->Distance = $distance;
		$this->Time = $time;
		$this->Weight = $weight;
		$this->SPM = $spm;
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
		$attempt = new Attempt($r['AthleteId'], $r['ChallengeId'], $r['Distance'], $r['Time'],
				$r['Weight'], $r['SPM']);
		
		$attempt->Id = $r['Id'];
		$attempt->AthleteName = $r['AthleteName'];
		$attempt->Entered = $r['Entered'];
		$attempt->PacePoints = $r['PacePoints'];
		$attempt->GainPoints = $r['GainPoints'];
		$attempt->TotalPacePoints = $r['TotalPacePoints'];
		$attempt->TotalGainPoints = $r['TotalGainPoints'];
		
		return $attempt;
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
order by ifnull(a.Time/(a.Distance/500), 10000),
       sp.PacePoints + sp.GainPoints desc";
		
		$attemptRecords = GetSelectResult($selectSQL);
	
		$attempts = array();
		foreach ($attemptRecords as $r)
		{
			$attempts[count($attempts)] = Attempt::CreateFromRecord($r);
		}
	
		return $attempts;
	}
	
	public static function UpdatePoints($challengeId)
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
order by this_pace - last_pace desc";
		
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