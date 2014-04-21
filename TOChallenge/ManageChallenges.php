<?php
	include_once 'ObjectChallenge.php';
	
	$challenges = Challenge::GetAll();
	$currentChallenge = Challenge::GetCurrent();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Team Oarsome Challenge</title>
		<link rel="stylesheet" type="text/css" href="TOstyle.css">
		<link rel="shortcut icon" href="img/TO.ico" />
	</head>
	
	<body>
		<div id="banner" > <img src="img/TObanner.png" alt="logo"></div>
	</body>
</html>