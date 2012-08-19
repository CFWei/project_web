<?php
	require_once("connect_mysql_class.php");
	require_once("mysql_inc.php");

	require_once("session.php");
	$se=new session();	
	if(!$SerialNumbers=$se->get_value("SerialNumbers"))
	{
		echo "******************取得SerialNumbers失敗******************";
		exit();
	}	

	$ItemID=$_POST['ItemID'];
	//$ID="8zMgCDbj1S";
	//$SerialNumbers="j5I5hh56nZVNqG3N4WcM";

	$db=new DB();
	$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	$query="UPDATE ".$SerialNumbers." SET State='DIE' where `ID`='".$ItemID."'";
	$db->query($query);

?>
<script>
alert("刪除成功");
loadpage("#content","managepage.php");
</script>
