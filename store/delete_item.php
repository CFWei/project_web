<?php
	require_once("../connect_mysql_class.php");
	require_once("../mysql_inc.php");

	$ID=$_POST['ID'];
	$SerialNumbers=$_POST['SerialNumbers'];
	//$ID="8zMgCDbj1S";
	//$SerialNumbers="j5I5hh56nZVNqG3N4WcM";

	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	$query="UPDATE ".$SerialNumbers." SET State='DIE' where `ID`='".$ID."'";
	$db->query($query);

	echo "success";
?>
