<?php

require_once("connect_mysql_class.php");
require_once("mysql_inc.php");


$db=new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);


$SerialNumber=$_GET['SerialNumber'];
$Item_Id=$_GET['Item_Id'];
$State=$_GET['State'];

if($State=="START")
	$State="STOP";
else
	$State="START";

	
$result=$db->query("UPDATE `".$SerialNumber."` SET `State`=\"".$State."\" where `ID` =\"".$Item_Id."\"");
if($result)
	echo "更動成功 目前狀態為".$State;
else
	echo "更動失敗";

header("Refresh: 1; url=\"manager.php\"");


?>


