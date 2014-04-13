<?php
  	include_once ("DBConnectivity.php");
		
	function GetConnection()
	{
		global $host;
		global $user;
		global $thingy;
		global $db;
	
		$mysqli = new mysqli($host, $user, $thingy, $db);
		if (mysqli_connect_errno())
		{
			echo "Connect failed: ".mysqli_connect_error();
			$mysqli = '';
		}
		
		return $mysqli;
	}
	
	function GetSelectResult($selectStatement)
	{
		$result = array();
		$mysqli = GetConnection();
		if (!empty($mysqli))
		{
			$selectResult = mysqli_query($mysqli, $selectStatement);
			
			if ($selectResult)
			{
				$recordCount = 0;
				while ($nextRecord = mysqli_fetch_array($selectResult, MYSQL_ASSOC))
				{
					$result[$recordCount] = $nextRecord;
					$recordCount++;
				}
				mysqli_free_result($selectResult);
			}
			mysqli_close($mysqli);
		}
	
		return $result;
	}
		
	function ExecuteStatement($statement)
	{
		$mysqli = GetConnection();
		if (!empty($mysqli))
		{
			mysqli_query($mysqli, $statement);
			mysqli_commit($mysqli);
		}
		mysqli_close($mysqli);
	}
?>